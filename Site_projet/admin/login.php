<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


require_once __DIR__ . '/../../envloader.php';

$env = charger_env();

$identifiant_admin = $env['ADMIN_USERNAME'];
$mot_de_passe_hash = $env['ADMIN_PASSWORD_HASH'];

// Si l’utilisateur est déjà connecté, redirige
if (isset($_SESSION['admin_connecté']) && $_SESSION['admin_connecté'] === true) {
    header('Location: index.php');
    exit();
}

// Traitement du formulaire
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($login === $identifiant_admin && password_verify($pass, $mot_de_passe_hash)) {
        $_SESSION['admin_connecté'] = true;
        header('Location: index.php');
        exit();
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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
  <i class="bi bi-house-fill"></i> Accueil
</a>


<div class="box">
    <h2 class="mb-3 text-center">Connexion Admin</h2>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="login" class="form-label">Identifiant</label>
            <input type="text" name="login" id="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Mot de passe</label>
            <input type="password" name="pass" id="pass" class="form-control" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btncta">Se connecter</button>
        </div>
    </form>
</div>

</body>
</html>
