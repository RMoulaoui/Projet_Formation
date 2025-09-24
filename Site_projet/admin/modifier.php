<?php
require_once __DIR__ . '/_session.php';

if (empty($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php'); exit;
}
require_once __DIR__ . '/../../config.php';

// Chemins (mêmes conventions qu'ajouter.php)
$rootDir     = dirname(__DIR__); // dossier parent de /admin
$baseDirRel  = 'images/projets';
$baseDirAbs  = $rootDir . '/' . $baseDirRel;
if (!is_dir($baseDirAbs)) { @mkdir($baseDirAbs, 0775, true); }


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
      if (!csrf_check($_POST['csrf'] ?? '')) {
    http_response_code(403);
    exit('Action non autorisée (CSRF).');
    }

    $titre = trim($_POST['titre'] ?? '');
    $description = htmlspecialchars(trim($_POST['description']));
    $image_url = htmlspecialchars(trim($_POST['image_url']));
    $image_path = $projet['image'];
    $lastUploadedAbs = null; // gardera le chemin ABS du nouveau fichier si upload OK


    
   // Si un nouveau fichier est uploadé, on le traite
if (!empty($_FILES['image_file']['name'])) {
    $tmp_name = $_FILES['image_file']['tmp_name'];
    $maxSize  = 3 * 1024 * 1024; // 3 Mo

    if (!is_uploaded_file($tmp_name)) {
        // on ignore
    } else {
        // MIME réel
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = $finfo ? finfo_file($finfo, $tmp_name) : null;
        if ($finfo) { finfo_close($finfo); }

        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        if (!$mime || !isset($mimeToExt[$mime])) {
            // on ignore
        } else {
            $ext = $mimeToExt[$mime];

            // Image réelle + taille
            $imgInfo = @getimagesize($tmp_name);
            if ($imgInfo !== false && filesize($tmp_name) <= $maxSize) {
                // Nommer depuis le NOUVEAU titre
                $baseName = slugify($titre ?: 'projet');
                $nameCandidate = $baseName . '-01'; // joli index; suffira dans 99% des cas ici

                $destRel = $baseDirRel . '/' . $nameCandidate . '.' . $ext;
                $destAbs = $baseDirAbs . '/' . $nameCandidate . '.' . $ext;

                // éviter collision
                $j = 1;
                while (file_exists($destAbs)) {
                    if (sha1_file($destAbs) === sha1_file($tmp_name)) { break; }
                    $destRel = $baseDirRel . '/' . $baseName . '-' . str_pad((string)(++$j), 2, '0', STR_PAD_LEFT) . '.' . $ext;
                    $destAbs = $baseDirAbs . '/' . $baseName . '-' . str_pad((string)$j, 2, '0', STR_PAD_LEFT) . '.' . $ext;
                }

                if (!file_exists($destAbs)) {
                    if (!move_uploaded_file($tmp_name, $destAbs)) {
                        // move échoué -> on n'update pas l'image
                    } else {
                        $image_path = $destRel;
                        $lastUploadedAbs = $destAbs;

                    }
                } else {
                    // fichier identique déjà présent
                    $image_path = $destRel;
                    $lastUploadedAbs = $destAbs;

                }
            }
        }
    }
}
elseif (!empty($image_url)) {
    $image_path = $image_url;
}

// Supprimer l'ancienne image locale si on a bien uploadé une nouvelle
if ($lastUploadedAbs
    && !empty($projet['image'])
    && !filter_var($projet['image'], FILTER_VALIDATE_URL)) {

    $oldAbs = $rootDir . '/' . ltrim($projet['image'], '/');
    if (is_file($oldAbs) && realpath($oldAbs) !== realpath($lastUploadedAbs)) {
        @unlink($oldAbs);
    }
}


// Si pas de nouvelle image uploadée ni d'URL fournie,
// mais que le titre change et que l'image est LOCALE, on renomme le fichier disque.
if (empty($_FILES['image_file']['name']) && empty($image_url)) {
    $oldTitleSlug = slugify($projet['titre'] ?? '');
    $newTitleSlug = slugify($titre ?? '');
    $isLocal = !filter_var($image_path, FILTER_VALIDATE_URL); // image stockée localement ?

    if ($isLocal && $newTitleSlug && $newTitleSlug !== $oldTitleSlug) {
        $oldRel = ltrim($image_path, '/'); // ex: images/projets/xxx.jpg
        $oldAbs = $rootDir . '/' . $oldRel;

        if (is_file($oldAbs)) {
            // déterminer extension (depuis MIME réel si possible)
            $ext = strtolower(pathinfo($oldAbs, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','webp'], true)) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = $finfo ? finfo_file($finfo, $oldAbs) : null;
                if ($finfo) { finfo_close($finfo); }
                $map = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
                if ($mime && isset($map[$mime])) $ext = $map[$mime];
            }
            if ($ext === 'jpeg') $ext = 'jpg';

            // nouveau nom basé sur le nouveau titre
            $baseName = $newTitleSlug;
            $nameCandidate = $baseName . '-01';
            $newRel = $baseDirRel . '/' . $nameCandidate . '.' . $ext;
            $newAbs = $baseDirAbs . '/' . $nameCandidate . '.' . $ext;

            // éviter collision
            $j = 1;
            while (file_exists($newAbs)) {
                if (sha1_file($newAbs) === sha1_file($oldAbs)) { break; }
                $newRel = $baseDirRel . '/' . $baseName . '-' . str_pad((string)(++$j), 2, '0', STR_PAD_LEFT) . '.' . $ext;
                $newAbs = $baseDirAbs . '/' . $baseName . '-' . str_pad((string)$j, 2, '0', STR_PAD_LEFT) . '.' . $ext;
            }

            // renommer si chemin différent
            if (realpath($oldAbs) !== realpath($newAbs)) {
                if (@rename($oldAbs, $newAbs)) {
                    $image_path = $newRel; // maj du chemin pour l'UPDATE
                }
                // si rename échoue on laisse l'ancien nom
            } else {
                $image_path = $newRel; // fichier identique déjà présent
            }
        }
    }
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
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES) ?>">

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($projet['titre'], ENT_QUOTES) ?>"required>
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
                <input type="file" name="image_file" class="form-control" accept="image/jpeg,image/png,image/webp">
            </div>
            <button type="submit" class="btncta">Enregistrer les modifications</button>
        </form>
    </div>
</body>

</html>