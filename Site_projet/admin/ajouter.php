<?php
session_start();

if (!isset($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titres = $_POST['titre'] ?? [];
    $descriptions = $_POST['description'] ?? [];
    $image_urls = $_POST['image_url'] ?? [];
    $image_files = $_FILES['image_file'] ?? [];

    $nb = count($titres);
    $errors = 0;

    for ($i = 0; $i < $nb; $i++) {
        $titre = htmlspecialchars(trim($titres[$i]));
        $description = htmlspecialchars(trim($descriptions[$i]));
        $image_path = '';

        // Option 1 : URL fournie
        if (!empty($image_urls[$i])) {
            $image_path = htmlspecialchars(trim($image_urls[$i]));
        }
        // Option 2 : fichier uploadé
        elseif (!empty($image_files['name'][$i])) {
            $tmp_name = $image_files['tmp_name'][$i];
            $original_name = basename($image_files['name'][$i]);
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extension, $allowed) && is_uploaded_file($tmp_name)) {
                $new_name = uniqid('img_', true) . '.' . $extension;
                $destination = '../images/projets/' . $new_name;
                $cheminEnBase = 'images/projets/' . $new_name;


                if (move_uploaded_file($tmp_name, $destination)) {
                $image_path = $cheminEnBase; 
                }

            }
        }

        // Enregistre si tout est OK
        if ($titre && $description && $image_path) {
            $stmt = $pdo->prepare("INSERT INTO projets (titre, description, image) VALUES (?, ?, ?)");
            $stmt->execute([$titre, $description, $image_path]);
        } else {
            $errors++;
        }
    }

    if ($errors === 0) {
        header("Location: index.php");
        exit();
    } else {
        $erreur = "Un ou plusieurs projets n'ont pas pu être ajoutés.";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ajouter un projet - Decopaint</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      background-color: #F4EDE4;
      color: #232323;
      font-family: sans-serif;
      padding: 2rem;
    }
    h1 {
      color: #1E3A5F;
    }
    label {
      font-weight: bold;
    }
    .btncta {
      background-color: #C7923E;
      color: #1E3A5F;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      margin-top: 1rem;
    }
    .btncta:hover {
      font-weight: bold;
    }
    .form-container {
      background: white;
      border-radius: 10px;
      padding: 2rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: auto;
    }
    a {
      color: #1E3A5F;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>

</head>


<body>
  <div class="form-container">
    <h1 class="mb-4">+ Ajouter un projet</h1>
    <a href="index.php">← Retour à la liste</a>

    <?php if (!empty($erreur)): ?>
      <div class="alert alert-danger mt-3"><?= $erreur ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mt-4">

        <div id="projets-container">

            <div class="projet-bloc mb-4 p-3 border rounded">

                <h5>Projet 1</h5>
                <div class="mb-2">
                    <label for="titre1">Titre</label>
                    <input type="text" name="titre[]" id="titre1" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="description1">Description</label>
                    <textarea name="description[]" id="description1" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-2">
                    <label for="image_url1">Image (URL)</label>
                    <input type="text" name="image_url[]" id="image_url1" class="form-control" placeholder="https://...">
                </div>
                <div class="mb-2">
                    <label for="image_file1">Ou charger une image depuis votre ordinateur</label>
                    <input type="file" name="image_file[]" id="image_file1" class="form-control" accept="image/*">
                </div>

            </div>

        </div>

        <button type="button" class="btn btn-secondary mb-3" id="addProjet">+ Ajouter un projet</button><br>
        <button type="submit" class="btncta">Enregistrer tous les projets</button>

    </form>


  </div>

    <script>

        let index = 2;

        document.getElementById('addProjet').addEventListener('click', function () {
        const container = document.getElementById('projets-container');
        const bloc = document.querySelector('.projet-bloc').cloneNode(true);

        bloc.querySelector('h5').innerText = `Projet ${index}`;

        // Met à jour les ID et vide les valeurs
        bloc.querySelectorAll('input, textarea').forEach(el => {
            const id = el.getAttribute('id');
            if (id) {
            const newId = id.replace(/\d+$/, '') + index;
            el.setAttribute('id', newId);
            }

            // Remet à zéro (text, textarea, file)
            if (el.type === "file") {
            el.value = null;
            } else {
            el.value = '';
            }
        });

        container.appendChild(bloc);
        index++;
        });

</script>


</body>


</html>
