<?php
session_start();
if (!isset($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<?php
require_once(__DIR__ . '/../../config.php');


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("ID invalide");
}


// Récupération du projet
$stmt = $pdo->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

if (!$projet) {
    die("Projet non trouvé");
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = htmlspecialchars(trim($_POST['titre']));
    $description = htmlspecialchars(trim($_POST['description']));
    $image_url = htmlspecialchars(trim($_POST['image_url']));
    $image_path = $projet['image'];

    // Si un nouveau fichier est uploadé, on le traite
    if (!empty($_FILES['image_file']['name'])) {
        $tmp_name = $_FILES['image_file']['tmp_name'];
        $original_name = basename($_FILES['image_file']['name']);
        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($extension, $allowed) && is_uploaded_file($tmp_name)) {
            $new_name = uniqid('img_', true) . '.' . $extension;
            $destination = '../images/projets/' . $new_name;
            if (move_uploaded_file($tmp_name, $destination)) {
                $image_path = 'images/projets/' . $new_name;
            }
        }
    } elseif (!empty($image_url)) {
        $image_path = $image_url;
    }

    $stmt = $pdo->prepare("UPDATE projets SET titre = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$titre, $description, $image_path, $id]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier le projet - Decopaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="p-4" style="background-color: #F4EDE4; color: #232323; font-family: sans-serif;">
    <div class="container bg-white rounded p-4 shadow" style="max-width: 600px;">
        <h1 class="mb-3" style="color: #1E3A5F;">Modifier le projet</h1>
        <a href="javascript:history.back()">← Retour à la liste</a>

        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($projet['titre']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($projet['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image actuelle</label><br>
                <img src="<?= filter_var($projet['image'], FILTER_VALIDATE_URL) ? $projet['image'] : '../' . $projet['image'] ?>" alt="Image actuelle" class="img-thumbnail mb-2" style="max-width: 200px;">
            </div>
            <div class="mb-3">
                <label class="form-label">Nouvelle image (URL)</label>
                <input type="text" name="image_url" class="form-control" placeholder="Laisser vide si inchangé">
            </div>
            <div class="mb-3">
                <label class="form-label">Ou téléverser une nouvelle image</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btncta">Enregistrer les modifications</button>
        </form>
    </div>
</body>

</html>