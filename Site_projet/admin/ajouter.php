<?php
require_once __DIR__ . '/_session.php'; // démarre la session + sécurité

// Garde d'accès (pages admin protégées)
if (empty($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../config.php'; // PDO
$erreur = '';


// === helpers ===
function slugify($text) {
    if (function_exists('iconv')) {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    }
    $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-a-z0-9]+~', '', $text);
    return $text ?: 'projet';
}

// Chemins (adapte si besoin selon ta structure)
$rootDir     = dirname(__DIR__); // dossier parent de /admin
$baseDirRel  = 'images/projets';
$baseDirAbs  = $rootDir . '/' . $baseDirRel;
if (!is_dir($baseDirAbs)) { @mkdir($baseDirAbs, 0775, true); }



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!csrf_check($_POST['csrf'] ?? '')) {
        http_response_code(403);
        exit('Action non autorisée (CSRF).');
    }

    $titres       = $_POST['titre'] ?? [];
    $descriptions = $_POST['description'] ?? [];
    $image_urls   = $_POST['image_url'] ?? [];
    $image_files  = $_FILES['image_file'] ?? [];

    $nb     = count($titres);
    $errors = 0;

    for ($i = 0; $i < $nb; $i++) {
        $titre       = trim($titres[$i] ?? '');
        $description = trim($descriptions[$i] ?? '');
        $image_path  = '';

        // Option 1 : URL fournie (on ne peut pas renommer une URL distante)
        if (!empty($image_urls[$i])) {
            $url = trim($image_urls[$i]);
            if (filter_var($url, FILTER_VALIDATE_URL) && preg_match('~^https?://~i', $url)) {
                $image_path = $url;
            }
        }

        // Option 2 : fichier uploadé (RENOMMÉ AU TITRE)
elseif (!empty($image_files['name'][$i])) {
    $tmp_name      = $image_files['tmp_name'][$i];
    $maxSize       = 3 * 1024 * 1024; // 3 Mo

    // Fichier réellement uploadé ?
    if (!is_uploaded_file($tmp_name)) { $errors++; continue; }

    // Vérif MIME RÉELLE (ne pas se fier à l'extension d'origine)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = $finfo ? finfo_file($finfo, $tmp_name) : null;
    if ($finfo) { finfo_close($finfo); }

    // Liste blanche MIME -> extension SÛRE
    $mimeToExt = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];
    if (!$mime || !isset($mimeToExt[$mime])) { $errors++; continue; }
    $extension = $mimeToExt[$mime];

    // Vérif image réelle
    $imgInfo = @getimagesize($tmp_name);
    if ($imgInfo === false) { $errors++; continue; }

    // Taille max
    if (filesize($tmp_name) > $maxSize) { $errors++; continue; }

    // === NOMMER LE FICHIER AVEC LE TITRE ===
    $baseName = slugify($titre ?: 'projet');

    // Option “joli nom par lot” : ajoute un index 01, 02... pour ce POST (évite les collisions si titres identiques)
    $index2 = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);
    $nameCandidate = $baseName . '-' . $index2; // ex: mon-projet-01

    $destRel = $baseDirRel . '/' . $nameCandidate . '.' . $extension;
    $destAbs = $baseDirAbs . '/' . $nameCandidate . '.' . $extension;

    // Si le nom est déjà pris, suffixe -1, -2, ...
    $j = 1;
    while (file_exists($destAbs)) {
        // Si contenu identique -> réutilise le fichier existant (évite doublon)
        if (sha1_file($destAbs) === sha1_file($tmp_name)) {
            break;
        }
        $destRel = $baseDirRel . '/' . $nameCandidate . '-' . $j . '.' . $extension;
        $destAbs = $baseDirAbs . '/' . $nameCandidate . '-' . $j . '.' . $extension;
        $j++;
    }

    // Écrire le fichier seulement si aucun identique n'existe
    if (!file_exists($destAbs)) {
        if (!move_uploaded_file($tmp_name, $destAbs)) { $errors++; continue; }
    }

    $image_path = $destRel;
}


        // === INSERT BDD pour CE projet ===
        if ($titre && $description && $image_path) {
            $stmt = $pdo->prepare("INSERT INTO projets (titre, description, image) VALUES (:t, :d, :p)");
            $stmt->execute([
                ':t' => $titre,
                ':d' => $description,
                ':p' => $image_path,
            ]);
        } else {
            $errors++;
        }
    } // <-- FIN de la boucle for

    if ($errors === 0) {
        header("Location: index.php?added=1");
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <div class="alert alert-danger mt-3"><?= htmlspecialchars($erreur, ENT_QUOTES) ?></div>
        <?php endif; ?>


        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">


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
                        <input type="file" name="image_file[]" id="image_file1" class="form-control" accept="image/jpeg,image/png,image/webp">
                    </div>

                </div>

            </div>

            <button type="button" class="btn btn-secondary mb-3" id="addProjet">+ Ajouter un projet</button><br>
            <button type="submit" class="btncta">Enregistrer tous les projets</button>

        </form>


    </div>

    <script>
        let index = 2;

        document.getElementById('addProjet').addEventListener('click', function() {
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