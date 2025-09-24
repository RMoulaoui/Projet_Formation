<?php ini_set('display_errors', 0);
error_reporting(0);
 ?>

<?php
require_once __DIR__ . '/../config.php';

$requete = $pdo->query("SELECT * FROM projets ORDER BY id DESC LIMIT 10");
$projets = $requete->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Decopaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>


<body class="accueil">
    <h1 class="visually-hidden">Decopaint – Fresques murales personnalisées</h1>

    <!-- Header -->

    <?php
      $page = 'accueil'; 
      include 'header.php';
    ?>


    <!-- Contenu -->

    <main>


        <!-- HERO -->
        <section id="hero" class="hero-section ">
            <div class="container text-center">
                <h2 class="fw-bold mb-3">Projet phare : Fresque murale</h2>
                <p class="lead ">Une réalisation unique au cœur de Saint-Étienne</p>
                <button id="btn-voir-projet" class="btncta mt-3">Découvrir le projet</button>
            </div>
        </section>

        <!-- Détails du projet (caché par défaut) -->
        <section id="details-projet" class="details-section d-none position-relative">

            <button id="btn-fermer-projet" class="close-btn" aria-label="Fermer">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="container py-3">
                <h2 class="fw-bold">Rencontre au café</h2>
                <p>
                    Ce mural coloré capture un moment suspendu dans le temps : deux personnages se croisent, portés par le vent, autour d’un café en terrasse. Les formes géométriques et les couleurs vives créent une atmosphère à la fois urbaine et chaleureuse, invitant le spectateur à imaginer leur histoire.
                </p>
                <img src="images/projets/projet-8.jpg" alt="Fresque murale" class="img-fluid rounded shadow m-2">
                <p>Les habitants peuvent admirer cette œuvre unique depuis 2025, symbole de créativité et de modernité.</p>
            </div>

        </section>


        <div class="d-flex flex-column align-items-center  ">

            <section id="quisommesnous" class="secondfond text-center m-0 ">

                <div class=" container-fluid col-md-10 col-lg-8 ">
                    <h2 class="mb-4  ">Qui sommes-nous ?</h2>
                    <p class="fw-bold  pb-3">
                        Chez Decopaint, nous transformons les murs en véritables œuvres d’art.
                        Spécialisés dans les fresques murales personnalisées, nous intervenons pour les particuliers comme pour les professionnels à la recherche d’une décoration unique et expressive.
                    </p>
                    <a href="quisommesnous.php" class="btncta" style="text-decoration: none;">
                        En savoir plus
                    </a>
                </div>

            </section>

            <div class="d-flex flex-column align-items-center my-5">

                <div class="container px-0">
 
                    <div class="custom-carousel mx-auto">

                        <button class="custom-prev">&#10094;</button>

                        <div class="custom-carousel-track">
                            <?php foreach ($projets as $projet): ?>
                            <div class="custom-carousel-slide">
                                <img src="<?= htmlspecialchars($projet['image']) ?>" alt="<?= htmlspecialchars($projet['titre']) ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="custom-next">&#10095;</button>
                    </div>

                    <div class="custom-carousel-dots d-none d-sm-flex justify-content-center mt-3"></div>
                </div>

                <h2 class="mt-3 ">Projets Réalisés</h2>
                <span class="mt-3">
                    <a class="btncta" href="portfolio.php" style="text-decoration: none">Voir nos préstations</a>
                </span>

            </div>


            <section id="avis-clients" class="secondfond py-5">
                <div class="container">
                    <h2 class="text-center mb-4 ">Avis Clients</h2>

                    <div class="row avis-clients-row g-4">

                        <div class="col-12  col-lg-4">
                            <div class="card avis-card h-100 p-3 shadow-sm">
                                <img src="https://i.pravatar.cc/60?img=12" class="client-photo rounded-circle mx-auto mb-3" alt="Jean Dupont">
                                <p class="mb-2 text-warning">⭐⭐⭐⭐⭐</p>
                                <p class="mb-3">"Super travail, très professionnel, je recommande vivement."</p>
                                <small class="text-muted">- Jean Dupont</small>
                            </div>
                        </div>

                        <div class="col-12  col-lg-4">
                            <div class="card avis-card h-100 p-3 shadow-sm">
                                <img src="https://i.pravatar.cc/60?img=10" class="client-photo rounded-circle mx-auto mb-3" alt="Marie Durand">
                                <p class="mb-2 text-warning">⭐⭐⭐⭐⭐</p>
                                <p class="mb-3">"Équipe réactive et à l’écoute, le résultat est parfait."</p>
                                <small class="text-muted">- Marie Durand</small>
                            </div>
                        </div>

                        <div class="col-12  col-lg-4">
                            <div class="card avis-card h-100 p-3 shadow-sm">
                                <img src="https://i.pravatar.cc/60?img=14" class="client-photo rounded-circle mx-auto mb-3" alt="Paul Martin">
                                <p class="mb-2 text-warning">⭐⭐⭐⭐⭐</p>
                                <p class="mb-3">"Travail rapide et soigné, je suis très satisfait."</p>
                                <small class="text-muted">- Paul Martin</small>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <div class="container-fluid row text-center p-5 justify-content-center">


                <div class="col-sm-8 text-center">
                    <h2 id="contact" class="mb-3">Un projet ? Une question ?</h2>
                    <p class="lead mb-5">
                        Pour toute demande ou devis, nous vous invitons à utiliser notre formulaire dédié.
                    </p>
                    <a href="contact.php" class="btncta">Nous contacter</a>
                </div>


            </div>

        </div>

    </main>

    <!-- Footer -->

    <?php
      include 'footer.php';
    ?>


    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 " href="#"><i class=" bi bi-chevron-double-up b"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/script.js"> </script>


</body>

</html>