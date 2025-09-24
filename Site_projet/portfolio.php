<?php ini_set('display_errors', 0); ?>

<?php
require_once __DIR__ . '/../config.php';
$stmt = $pdo->query("SELECT * FROM projets ORDER BY id DESC");
$projets = $stmt->fetchAll();
?>


<!doctype html>

<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Decopaint - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


</head>


<body>

    <!-- Header -->
     
     <?php
    $page = 'portfolio'; 
    include 'header.php';
    ?>
    
    <div class="main-content">

          

        <!-- Contenu -->

        <main>


            <div class="container  px-3  text-center">
                <div id="portfo" class="d-flex row justify-content-center  ">

                    <h1 class=" col-12 fw-bold py-5  "><i class="fi fi-rs-briefcase"></i> Portfolio</h1>

                    <?php $i = 0; ?>

                    <?php foreach ($projets as $projet): ?>
                    <?php
                        $i++;
                        $classe = 'col m-3 p-0 fw-bold';
                        if ($i > 6) $classe .= ' suiteportfo';
                    ?>

                    <div class="<?= $classe ?>">
                        <img class="zoom imgportfo mb-1" 
                            src="<?= htmlspecialchars($projet['image']) ?>" 
                            alt="<?= htmlspecialchars($projet['titre']) ?>" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Modal" 
                            data-index="<?= $i - 1 ?>">
                        <p><?= htmlspecialchars($projet['titre']) ?></p>
                    </div>

                    <?php endforeach; ?>

                    <?php if (count($projets) > 6): ?>

                    <div class="col-12 mb-5">
                        <button class="voirplus btncta">
                            <i class="fi fi-tr-angle-circle-down"></i> Voir plus...
                        </button>
                    </div>

                    <?php endif; ?>


                </div>
            </div>


            <div class="modal fade " id="Modal" tabindex="-1" aria-labelledby="ModalLabel">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header justify-content-center position-relative p-2">

                            <div class="d-flex align-items-center" style="gap: 0.25rem;">
                                <button class="bouton-titre" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </button>

                                <h1 class="modal-title m-0" id="ModalLabel"> PROJETS </h1>

                                <button class="bouton-titre" type="button" data-bs-target="#carousel" data-bs-slide="next">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>

                            <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>


                        <div class="modal-body">
                            <div id="carousel" class="carousel slide">

                                <div class="carousel-inner">
                                    <?php foreach ($projets as $index => $projet): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="<?= htmlspecialchars($projet['image']) ?>" class="modal-img-grande mx-auto d-block" alt="<?= htmlspecialchars($projet['titre']) ?>">
                                        <div class="description-projet text-center fw-bold ">
                                            <?= nl2br(htmlspecialchars($projet['description'])) ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    </div>

    <!-- Footer -->

    <?php
    include 'footer.php';
  ?>


    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 border border-light" href="#"><i class="text-light bi bi-chevron-double-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"> </script>
    <script src="js/script.js"> </script>

</body>


</html>