<?php
session_start();
if (!isset($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<?php
require_once '../config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Vérifie si le projet existe avant de supprimer
    $stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
    $stmt->execute([$id]);
    $projet = $stmt->fetch();

    if ($projet) {
        // Suppression
        $delete = $pdo->prepare("DELETE FROM projets WHERE id = ?");
        $delete->execute([$id]);
        $message = "Projet supprimé avec succès.";
    } else {
        $message = "Projet introuvable.";
    }
} else {
    $message = "ID invalide.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="UTF-8">
  <title>Suppression - Decopaint</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      background-color: #F4EDE4;
      color: #232323;
      font-family: sans-serif;
      padding: 2rem;
      text-align: center;
    }
    h1 {
      color: #1E3A5F;
    }
    .message {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    a {
      display: inline-block;
      margin-top: 1rem;
      color: #1E3A5F;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
  <meta http-equiv="refresh" content="2;url=index.php"> <!-- Redirection auto -->

</head>

<body>

  <div class="message">
    <h1>Suppression de projet</h1>
    <p><?= $message ?></p>
    <p><small>Redirection vers le tableau dans 2 secondes...</small></p>
    <a href="index.php">⏎ Retour immédiat</a>
  </div>

</body>

</html>
