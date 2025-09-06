<?php ini_set('display_errors', 0); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentions Légales - Decopaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background-color: #F4EDE4;
            color: #232323;
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
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

        footer {
            background-color: #1E3A5F;
            color: #F4EDE4;
            text-align: center;
            padding: 1rem 0;
        }

        a {
            color: #C7923E;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="contact-page">

    <div class="main-content">

        <!-- Header -->

        <?php 
    include 'header.php';
  ?>

        <!-- Contenu -->

        <div class="container my-5">

            <div class="mentions-container">

                <h1 class="mb-4">Mentions Légales</h1>

                <h2>Éditeur du site</h2>
                <p><strong>Nom du site :</strong> Decopaint<br>
                    <strong>Responsable de publication :</strong> Moulaoui Ryan<br>
                    <strong>Adresse :</strong> 14 Rue Paul et Pierre Guichard 42000 Saint-Etienne<br>
                    <strong>Email :</strong> contact@decopaint.fr
                </p>

                <h2>Hébergement</h2>
                <p><strong>Hébergeur :</strong> OVH SAS
                    2 rue Kellermann, 59100 Roubaix, France</p>

                <h2>Propriété intellectuelle</h2>
                <p>Le contenu du site Decopaint (textes, images, logos, etc.) est protégé par le droit d’auteur. Toute reproduction est interdite sans autorisation préalable.</p>

                <h2>Collecte de données</h2>
                <p>Les données personnelles collectées via le formulaire de contact sont utilisées uniquement pour répondre aux demandes. Aucune donnée n’est cédée à des tiers.</p>

                <h2>Cookies</h2>
                <p>Le site Decopaint n’utilise pas de cookies à des fins de suivi ou de publicité.</p>

            </div>

        </div>

    </div>

    <!-- Footer -->

    <?php
    $page = 'mentions';
    include 'footer.php';
  ?>

    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 border border-light" href="#"><i class="text-light bi bi-chevron-double-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"> </script>

</body>

</html>