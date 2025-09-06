<?php ini_set('display_errors', 0); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Politique de Confidentialité - Decopaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #F4EDE4;
            color: #232323;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .mentions-container {
            max-width: 900px;
            margin: auto;
            padding: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #1E3A5F;
        }

        a {
            color: #C7923E;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Header -->

    <?php 
  include 'header.php';
?>

    <!-- Contenu -->

    <div class="container my-5">

        <div class="mentions-container">

            <h1 class="mb-4">Politique de Confidentialité</h1>

            <h2>Données collectées</h2>
            <p>Nous recueillons les informations que vous nous transmettez via le formulaire de contact. Ces données sont utilisées uniquement pour répondre à votre demande. Les données personnelles collectées ne sont utilisées que dans le cadre de l’activité de Decopaint. Elles ne sont en aucun cas revendues ou partagées à des tiers.</p>


            <h2>Durée de conservation</h2>
            <p>Vos données sont conservées le temps nécessaire au traitement de votre demande, et supprimées après réponse si aucune suite n’est donnée.</p>

            <h2>Droit d’accès, de rectification et de suppression</h2>
            <p>Conformément à la réglementation en vigueur, vous pouvez à tout moment demander l’accès, la modification ou la suppression de vos données personnelles en nous contactant à <a href="mailto:contact@decopaint.fr">contact@decopaint.fr</a>.</p>

            <h2>Cookies</h2>
            <p>Le site Decopaint ne dépose pas de cookies de suivi ou publicitaires. Seuls les cookies techniques nécessaires à son bon fonctionnement peuvent être utilisés.</p>

            <h2>Sécurité</h2>
            <p>Vos données sont traitées de manière confidentielle et sécurisée.</p>
        </div>
    </div>

    <!-- Footer -->

    <?php
  $page = 'politique';
  include 'footer.php';
?>


    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 border border-light" href="#"><i class="text-light bi bi-chevron-double-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>