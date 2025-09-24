<?php
require_once __DIR__ . '/_session.php';
ini_set('display_errors', 0);

require_once __DIR__ . '/../../envloader.php';
$env = charger_env();

$identifiant_admin = $env['ADMIN_USERNAME'] ?? '';
$mot_de_passe_hash = $env['ADMIN_PASSWORD_HASH'] ?? '';


$erreur = '';

// Si l’utilisateur est déjà connecté, redirige
if (isset($_SESSION['admin_connecté']) && $_SESSION['admin_connecté'] === true) {
    header('Location: index.php');
    exit();
}
// ---- Rate-limit PAR IP (sans BDD) ----
$RATE_DIR = __DIR__ . '/_rate';
if (!is_dir($RATE_DIR)) { @mkdir($RATE_DIR, 0775, true); }

$now = time(); // on le déclare ici (on n'en redéclarera pas plus bas)
$ip_raw  = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$ip_sane = preg_replace('~[^a-z0-9_.:-]~i', '_', $ip_raw);
$ipFile  = $RATE_DIR . '/ip-' . $ip_sane . '.json';

$IP_WINDOW    = 600;   // 10 min (fenêtre d'observation)
$IP_THRESHOLD = 12;    // 12 échecs dans la fenêtre
$IP_LOCK      = 1800;  // 30 min de verrouillage

$ipData = ['fails' => [], 'lock_until' => 0];
if (is_file($ipFile)) {
    $raw = @file_get_contents($ipFile);
    $tmp = $raw ? json_decode($raw, true) : null;
    if (is_array($tmp)) { $ipData = $tmp + $ipData; }
}
// purge des échecs trop anciens
$ipData['fails'] = array_values(array_filter($ipData['fails'], function($t) use ($now, $IP_WINDOW) {
    return ($now - (int)$t) <= $IP_WINDOW;
}));

$ip_locked = ($now < (int)($ipData['lock_until'] ?? 0));
$ip_error  = $ip_locked
    ? "Trop de tentatives depuis votre adresse IP. Réessayez dans ~" . max(1, ceil(($ipData['lock_until'] - $now)/60)) . " minute(s)."
    : '';


// Anti-brutforce simple
$ip   = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$key  = 'login_guard';
$_SESSION[$key] = $_SESSION[$key] ?? ['tries'=>0,'lock_until'=>0,'ip'=>$ip];

if (!empty($ip_locked)) {
    $erreur = $ip_error;
    header('HTTP/1.1 429 Too Many Requests');
    header('Retry-After: ' . max(60, ($ipData['lock_until'] - $now)));

} elseif ($now < ($_SESSION[$key]['lock_until'] ?? 0)) {
    $wait = $_SESSION[$key]['lock_until'] - $now;
    $erreur = "Trop de tentatives. Réessayez dans " . ceil($wait/60) . " min.";
    header('HTTP/1.1 429 Too Many Requests');
    header('Retry-After: ' . max(60, ($_SESSION[$key]['lock_until'] - $now)));

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = (string)($_POST['pass'] ?? '');

    if ($login === $identifiant_admin && password_verify($pass, $mot_de_passe_hash)) {
        $_SESSION[$key] = ['tries'=>0,'lock_until'=>0,'ip'=>$ip];
        session_regenerate_id(true);
        $_SESSION['admin_connecté'] = true;
        $_SESSION['admin_user']     = $identifiant_admin;
        $_SESSION['login_time']     = time();
        $_SESSION['ua_hash']        = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
        $_SESSION['ip_octets']      = implode('.', array_slice(explode('.', $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 3));
        // --- succès : reset compteur IP ---
        $ipData = ['fails' => [], 'lock_until' => 0];
        @file_put_contents($ipFile, json_encode($ipData), LOCK_EX);

        header('Location: index.php'); exit;
    } else {
        $_SESSION[$key]['tries']++;
        if ($_SESSION[$key]['tries'] >= 5) { // 5 échecs -> 10 min
            $_SESSION[$key]['lock_until'] = $now + 600;
        }
        // --- échec côté IP ---
        $ipData['fails'][] = $now;
        if (count($ipData['fails']) >= $IP_THRESHOLD) {
            $ipData['lock_until'] = $now + $IP_LOCK;
        }
        @file_put_contents($ipFile, json_encode($ipData), LOCK_EX);

        $erreur = "Identifiants incorrects.";
    }
}
$locked = $ip_locked || ($now < ($_SESSION[$key]['lock_until'] ?? 0));



?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Admin - Decopaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F4EDE4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #232323;
        }

        .box {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .btncta {
            background-color: #C7923E;
            color: #1E3A5F;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
        }

        .btn-retour-admin {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 1000;
            background-color: #1E3A5F;
            color: #F4EDE4;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }

        .btn-retour-admin:hover {
            background-color: #C7923E;
            color: white;
        }
    </style>
</head>

<body>

    <a href="../index.php" class="btn-retour-admin">
         Accueil
    </a>


    <div class="box">
        <h2 class="mb-3 text-center">Connexion Admin</h2>

        <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="login" class="form-label">Identifiant</label>
                <input type="text" name="login" id="login" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Mot de passe</label>
                <input type="password" name="pass" id="pass" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btncta" <?= !empty($locked) ? 'disabled' : '' ?>>Se connecter</button>

            </div>
        </form>
    </div>

</body>

</html>