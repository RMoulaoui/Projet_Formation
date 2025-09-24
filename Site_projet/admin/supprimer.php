<?php
require_once __DIR__ . '/_session.php';

if (empty($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php'); exit;
}
require_once __DIR__ . '/../../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php'); exit;
}

if (!csrf_check($_POST['csrf'] ?? '')) {
    http_response_code(403);
    exit('Action non autorisée (CSRF).');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$message = '';

if (!$id) {
    $message = "ID invalide.";
} else {
    // 1) Récupérer le chemin de l'image avant suppression
    $stmt = $pdo->prepare("SELECT image FROM projets WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $imageRel = $stmt->fetchColumn();

    if ($imageRel === false) {
        $message = "Projet introuvable.";
    } else {
        // 2) Supprimer la ligne
        $del = $pdo->prepare("DELETE FROM projets WHERE id = :id");
        $del->execute([':id' => $id]);

        // 3) Si l'image est locale, vérifier si elle est encore référencée
        $shouldDeleteFile = false;
        $isUrl = stripos($imageRel, 'http') === 0;

        // On ne supprime que si c'est bien un chemin local vers images/projets
        if (!$isUrl && preg_match('~^images/projets(?:/|$)~', $imageRel)) {
            $check = $pdo->prepare("SELECT COUNT(*) FROM projets WHERE image = :p");
            $check->execute([':p' => $imageRel]);
            $stillUsed = (int) $check->fetchColumn();

            if ($stillUsed === 0) {
                $shouldDeleteFile = true;
            }
        }

        // 4) Supprimer physiquement si plus référencé
        if ($shouldDeleteFile) {
            $rootDir = dirname(__DIR__); // parent de /admin
            $absPath = $rootDir . '/' . ltrim($imageRel, '/');

            if (is_file($absPath)) {
                @unlink($absPath);
            }

            // (optionnel) supprimer aussi une miniature si tu en génères
            // $thumbRel = preg_replace('~^images/projets/~', 'images/projets/thumbs/', $imageRel);
            // $thumbAbs = $rootDir . '/' . $thumbRel;
            // if (is_file($thumbAbs)) { @unlink($thumbAbs); }
        }

        $message = "Projet supprimé avec succès.";
    }
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
        body { background-color:#F4EDE4; color:#232323; font-family:sans-serif; padding:2rem; text-align:center; }
        h1 { color:#1E3A5F; }
        .message { background:#fff; padding:2rem; border-radius:10px; max-width:500px; margin:auto; box-shadow:0 0 10px rgba(0,0,0,.1); }
        a { display:inline-block; margin-top:1rem; color:#1E3A5F; text-decoration:none; }
        a:hover { text-decoration:underline; }
    </style>
    <meta http-equiv="refresh" content="2;url=index.php"><!-- Redirection auto -->
</head>
<body>
    <div class="message">
        <h1>Suppression de projet</h1>
        <p><?= htmlspecialchars($message, ENT_QUOTES) ?></p>
        <p><small>Redirection vers le tableau dans 2 secondes...</small></p>
        <a href="index.php">⏎ Retour immédiat</a>
    </div>
</body>
</html>
