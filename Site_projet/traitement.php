<?php ini_set('display_errors', 0);

 ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
    die("Erreur : Le prénom ou le nom contient des caractères non autorisés.");
}

try {
    $mail = new PHPMailer(true);

    // Configuration SMTP
    $mailConfig = require __DIR__ . '/../config_mail.php';

    $mail->Host       = $mailConfig['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailConfig['smtp_user'];
    $mail->Password   = $mailConfig['smtp_pass'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $mailConfig['smtp_port'];

    // Expéditeur et destinataire
    $mail->setFrom('testdecopaint@gmail.com', 'Formulaire Decopaint');
    $mail->addReplyTo($email, "$prenom $nom");

    $mail->addAddress('testdecopaint@gmail.com'); 

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau message depuis le site Decopaint';
    $mail->Body = "
    <strong>Statut :</strong> $statut<br>
    <strong>Nom :</strong> $nom<br>
    <strong>Prénom :</strong> $prenom<br>
    <strong>Email :</strong> $email<br>
    <strong>Message :</strong><br>" . nl2br($message);
    $mail->AltBody = "Statut : $statut\nNom : $nom\nPrénom : $prenom\nEmail : $email\nMessage :\n$message";



    $mail->send();
    header("Location: merci.html");
    exit();

} catch (Exception $e) {
    echo "Erreur : le message n'a pas pu être envoyé.<br>";
    echo "Mailer Error : {$mail->ErrorInfo}";
}
?>
