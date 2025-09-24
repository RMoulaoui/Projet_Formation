<?php ini_set('display_errors', 0); ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Qui sommes-nous - Decopaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php 
      $page = 'quisommesnous';
      include 'header.php'; 
    ?>

    <main>

        <!-- Intro fond beige -->
        <section class="py-5" style="background-color:#F4EDE4; color:#232323;">
            <div class="container text-center">
                <h1 class="mb-3">Qui sommes-nous ?</h1>
                <p class="lead">
                    Decopaint est né d’une passion commune pour l’art et l’envie de transformer les espaces en véritables lieux d’expression.
                    Depuis nos débuts, nous accompagnons particuliers et entreprises pour donner vie à leurs idées à travers des fresques murales uniques.
                </p>
            </div>
        </section>

        <!-- Mission fond bleu -->
        <section class="secondfond py-5 ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2>Notre mission</h2>
                        <p>
                            Notre objectif est clair : apporter une touche d’originalité et de personnalité à chaque espace que nous décorons.
                            Que ce soit pour embellir un salon, donner une âme à un restaurant, ou affirmer l’identité visuelle d’un commerce,
                            chaque projet est abordé avec la même exigence de qualité et de créativité.
                            Nous croyons que l’art doit être accessible à tous et qu’il a le pouvoir de transformer notre quotidien.
                        </p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="images/projets/projet-2.jpg" alt="Fresque murale" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <!-- Savoir-faire fond bleu -->
        <section class=" py-5 " style="background-color:#F4EDE4; color:#232323;">
            <div class="container">
                <div class="row align-items-center flex-md-row-reverse">
                    <div class="col-md-6">
                        <h2>Notre savoir-faire</h2>
                        <p>
                            De la conception initiale à la touche finale, chaque étape est réalisée avec soin.
                            Nous travaillons avec des matériaux de haute qualité et utilisons des techniques
                            adaptées pour garantir la durabilité de nos fresques, même dans les environnements les plus exigeants.
                            Grâce à notre expérience, nous savons marier tradition et modernité pour un résultat toujours unique.
                        </p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="images/projets/projet-5.jpg" alt="Atelier Decopaint" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <!-- Valeurs fond beige -->
        <section class="secondfond py-5">
            <div class="container text-center">
                <h2 class="mb-5">Nos valeurs</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <i class="bi bi-brush-fill" style="font-size:3rem; color:#C7923E;"></i>
                        <h4>Créativité</h4>
                        <p>
                            Nous explorons sans cesse de nouvelles idées, techniques et inspirations
                            afin que chaque fresque soit une œuvre authentique, qui ne ressemble à aucune autre.
                        </p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <i class="bi bi-people-fill" style="font-size:3rem; color:#C7923E;"></i>
                        <h4>Personnalisation</h4>
                        <p>
                            Chaque projet est conçu sur-mesure. Nous écoutons attentivement vos envies,
                            vos goûts et vos contraintes pour créer une fresque qui vous ressemble vraiment.
                        </p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <i class="bi bi-building-fill" style="font-size:3rem; color:#C7923E;"></i>
                        <h4>Harmonie</h4>
                        <p>
                            Nos créations s’intègrent parfaitement à l’architecture et à l’ambiance des lieux,
                            en respectant les volumes, les couleurs existantes et la lumière naturelle.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Appel à l'action fond beige -->
        <section class="container py-5 text-center" style="background-color:#F4EDE4; color:#232323;">
            <h2 class="mb-4">Vous avez un projet ?</h2>
            <p class="mb-4">
                Parlons-en ! Ensemble, nous pouvons imaginer et créer la fresque qui donnera vie à vos espaces
                et marquera durablement les esprits.
                Que ce soit pour votre intérieur, votre commerce ou un événement spécial,
                Decopaint est à vos côtés pour concrétiser vos idées les plus audacieuses.
            </p>
            <a href="contact.php" class="btncta">Contactez-nous</a>
        </section>

    </main>

    <?php include 'footer.php'; ?>

    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 " href="#"><i class=" bi bi-chevron-double-up b"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/script.js"> </script>

</body>

</html>