<?php ini_set('display_errors', 0);
error_reporting(0);
 ?>





<?php
require_once __DIR__ . '/../config.php';

$requete = $pdo->query("SELECT * FROM projets LIMIT 10");
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
     
    
      <div class="d-flex flex-column align-items-center  ">

      <section id="quisommesnous"  class=" text-center m-0 pb-3">

        <div class="container-fluid col-md-10 col-lg-8 ">
          <h2 class="mb-4 display-5 texte-clair">Qui sommes-nous ?</h2>
          <p class="fw-bold texte-clair">
            Chez Decopaint, nous transformons les murs en véritables œuvres d’art. 
            Spécialisés dans les fresques murales personnalisées, nous intervenons pour les particuliers comme pour les professionnels à la recherche d’une décoration unique et expressive.
          </p>
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


        <div class=" secondfond section-carte container-fluid text-center p-4 " >

            <h2 class="texte-clair">Où nous trouver ?</h2>
            <address class="texte-clair">
              14 Rue Paul et Pierre Guichard, 42000 Saint-Étienne
            </address>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2798.4607971331534!2d4.386859076652695!3d45.46052073368363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f5ac72b5162507%3A0x8082a74595924a0a!2sStade%20Geoffroy-Guichard!5e0!3m2!1sfr!2sfr!4v1753727090328!5m2!1sfr!2sfr"
                    height="400px"
                    style="border: 3px solid #F4EDE4; max-width: 90%;margin: 25px; border-radius: 15px; padding : 5px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    >
            </iframe>
          
        </div>
        
        
        <div class="container-fluid row text-center p-5 justify-content-center" >
          
          
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
 
        
        
    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 " href="#"><i class=" bi bi-chevron-double-up b" ></i></a>
    
    <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/script.js"> </script>
    

  </body>
</html>