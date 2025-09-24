<?php
ini_set('display_errors', 0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// --- (Optionnel) Honeypot anti-bot ultra simple ---
if (!empty($_POST['website'] ?? '')) {
    // Champ piège rempli => bot
    http_response_code(204);
    exit;
}

// --- (Optionnel) Vérif RGPD côté serveur ---
if (empty($_POST['rgpd'])) {
    header('Location: contact.php?error=rgpd#form-contact');
    exit;
}

// --- reCAPTCHA v2 : vérification côté serveur ---
require_once __DIR__ . '/../envloader.php'; // adapte le chemin si besoin
$env = isset($env) ? $env : charger_env();

$captchaToken = $_POST['g-recaptcha-response'] ?? '';
if (!$captchaToken) {
    header('Location: contact.php?error=captcha#form-contact'); exit;
}

$secret = $env['RECAPTCHA_SECRET_KEY'] ?? '';
if (empty($secret)) {
    // SECRET non trouvé -> log et refuse
    @error_log(date('[Y-m-d H:i:s] ')."reCAPTCHA: SECRET manquant\n", 3, '/tmp/recaptcha.log');
    header('Location: contact.php?error=captcha#form-contact'); exit;
}

$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$payload = http_build_query([
    'secret'   => $secret,
    'response' => $captchaToken,
    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null,
], '', '&');

// --- Tentative 1 : cURL ---
$json = null; $netErr = null;
if (function_exists('curl_init')) {
    $ch = curl_init($verifyUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
    ]);
    $res = curl_exec($ch);
    if ($res === false) {
        $netErr = 'cURL error: ' . curl_error($ch);
    }
    curl_close($ch);
    if ($res) {
        $json = json_decode($res, true);
    }
}

// --- Tentative 2 : fallback file_get_contents si pas de cURL ou échec ---
if (!$json) {
    $ctx = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => $payload,
            'timeout' => 5,
        ]
    ]);
    $res = @file_get_contents($verifyUrl, false, $ctx);
    if ($res) {
        $json = json_decode($res, true);
    } else {
        $netErr = $netErr ?: 'file_get_contents failed';
    }
}

// --- Vérification du résultat ---
if (!$json || empty($json['success'])) {
    // Log utile pour diagnostiquer
    @error_log(date('[Y-m-d H:i:s] ')."reCAPTCHA fail. netErr={$netErr}; json=" . json_encode($json) . "\n", 3, '/tmp/recaptcha.log');
    header('Location: contact.php?error=captcha#form-contact'); exit;
}

// (Optionnel) Sécurité supplémentaire : vérifier l'hostname renvoyé par Google
// if (!empty($json['hostname']) && stripos($json['hostname'], 'decopaint.fr') === false) {
//     @error_log(date('[Y-m-d H:i:s] ')."Hostname mismatch: ".$json['hostname']."\n", 3, '/tmp/recaptcha.log');
//     header('Location: contact.php?error=captcha#form-contact'); exit;
// }

// >>> À partir d’ici, le CAPTCHA est validé <<<



// Sécurisation des champs
$prenom = htmlspecialchars(trim($_POST['prenom']));
$nom = htmlspecialchars(trim($_POST['nom']));
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$message = strip_tags(trim($_POST['message']));
$statut = isset($_POST['statut']) ? $_POST['statut'] : 'Non précisé';


// Suppression des caractères suspects dans l’email (protection anti-injection)
$email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $email);

// Vérifications côté serveur (double protection)
if (!$prenom || !$nom || !$email || !$message) {
    die("Erreur : Tous les champs sont requis.");
}

if (!preg_match("/^[A-Za-zÀ-ÿ \-']+$/", $prenom) || !preg_match("/^[A-Za-zÀ-ÿ \-']+$/", $nom)) {
    header("Location: contact.php?error=nomprenom");
    exit();
}


try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();

    // Configuration SMTP
    require_once __DIR__ . '/../config_mail.php';
    $mailConfig = mail_config();

    $mail->Host       = $mailConfig['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailConfig['username'];
    $mail->Password   = $mailConfig['password'];
    $mail->Port       = $mailConfig['port'];
    $mail->SMTPSecure = ($mailConfig['encryption'] === 'tls')
        ? PHPMailer::ENCRYPTION_STARTTLS
        : PHPMailer::ENCRYPTION_SMTPS;

    // Expéditeur et destinataire (via .env)
    $mail->setFrom($mailConfig['from'], 'Formulaire Decopaint');
    $mail->addReplyTo($email, "$prenom $nom");
    $mail->addAddress($mailConfig['to']);

    // Contenu
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau message depuis le site Decopaint';
    $mail->Body = "
    <html>
    <head><meta charset='UTF-8'></head>
    <body>
        <strong>Statut :</strong> $statut<br>
        <strong>Nom :</strong> $nom<br>
        <strong>Prénom :</strong> $prenom<br>
        <strong>Email :</strong> $email<br>
        <strong>Message :</strong><br><br>" . nl2br($message) . "
    </body>
    </html>";
    $mail->AltBody = "Statut : $statut\nNom : $nom\nPrénom : $prenom\nEmail : $email\nMessage :\n$message";


    @error_log(date('[Y-m-d H:i:s] ')."TRY_SEND from IP=".($_SERVER['REMOTE_ADDR'] ?? 'n/a')." email=$email\n", 3, '/tmp/form_send.log');

    $mail->send();
    @error_log(date('[Y-m-d H:i:s] ')."SENT_OK IP=".($_SERVER['REMOTE_ADDR'] ?? 'n/a')." email=$email\n", 3, '/tmp/form_send.log');

    header("Location: merci.php");
    exit();

} catch (Exception $e) {
    @error_log(date('[Y-m-d H:i:s] ')."SENT_FAIL IP=".($_SERVER['REMOTE_ADDR'] ?? 'n/a')." email=$email ERR=".($mail->ErrorInfo ?? 'n/a')."\n", 3, '/tmp/form_send.log');

    echo "Erreur : le message n'a pas pu être envoyé.<br>";
    echo "Mailer Error : {$mail->ErrorInfo}";
}
?>