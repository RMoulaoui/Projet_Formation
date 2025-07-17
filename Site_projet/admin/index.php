<?php ini_set('display_errors', 0);


session_start();
if (!isset($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<?php
require_once(__DIR__ . '/../../config.php');


// Nombre de projets par page
$limite = 6;

// Page actuelle (par défaut = 1)
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limite;

// Récupération des projets avec LIMIT
$stmt = $pdo->prepare("SELECT * FROM projets ORDER BY id DESC LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$projets = $stmt->fetchAll();

// Nombre total de projets
$total = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();
$nbPages = ceil($total / $limite);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Decopaint</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      background-color: #F4EDE4;
      color: #232323;
      font-family: sans-serif;
      padding: 2rem;
    }

    h1, h2 {
      color: #1E3A5F;
      font-weight: bold;
    }

    a {
      color: #1E3A5F;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .btnajout {
      background-color: #C7923E;
      color: #1E3A5F;
      padding: 8px 16px;
      border: none;
      border-radius: 8px;
    }

    .btnajout:hover {
      font-weight: bold;
    }

    .projet {
      background: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 2rem;
      box-shadow: 1px 1px 6px rgba(0,0,0,0.1);
    }

    .table td, .table th {
    vertical-align: middle;
    }

    .btn-outline-dark {
    color: #1E3A5F;
    border-color: #1E3A5F;
    }

    .btn-outline-dark:hover {
    background-color: #C7923E;
    color: white;
    font-weight: bold;
    }

    @media (max-width: 576px) {
      body {
        padding: 1rem;
      }
      
      .d-flex.justify-content-between {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 1rem;
      }

      .btnajout,
      .btn-outline-dark {
        width: 100%;
        text-align: center;
      }

      td img {
        max-width: 100%;
        height: auto;
      }

      .table td, .table th {
        font-size: 0.9rem;
        word-break: break-word;
      }
    }


  </style>
</head>


<body>


  <h1 class="mb-4">Back-office Decopaint</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="ajouter.php" class="btnajout">+ Ajouter un projet</a>
      <div class="d-flex gap-2">
        <a href="../index.php" class="btn btn-outline-dark">
          <i class="bi bi-house-fill"></i> Accueil
        </a>
        <a href="logout.php" class="btn btn-outline-dark">Déconnexion</a>
      </div>
    </div>




    <?php if (empty($projets)): ?>
    <p>Aucun projet pour le moment.</p>
    <?php else: ?>

        <div class="table-responsive">
          <table class="table table-bordered table-hover bg-white">

        
            <thead class="table-light">
                <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Description</th>
                <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($projets as $projet): ?>
                <tr>
                    <td style="max-width: 120px;">
                    <?php
                        $cheminImage = $projet['image'];
                        if (!filter_var($cheminImage, FILTER_VALIDATE_URL)) {
                        $cheminImage = '../' . $cheminImage;
                        }
                    ?>
                    <img src="<?= htmlspecialchars($cheminImage) ?>" alt="Image" style="width: 100px;" class="img-thumbnail">
                    </td>
                    <td><?= htmlspecialchars($projet['titre']) ?></td>
                    <td style="max-width: 300px;"><?= nl2br(htmlspecialchars($projet['description'])) ?></td>
                    <td class="text-center align-middle" style="white-space: nowrap;">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="modifier.php?id=<?= $projet['id'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="supprimer.php?id=<?= $projet['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce projet ?')">Supprimer</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>

          </table>
        </div>

        <nav aria-label="Pagination" class="text-center mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">← Précédent</a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $nbPages; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $nbPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant →</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>



    <?php endif; ?>


</body>

</html>
