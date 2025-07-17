<?php ini_set('display_errors', 0);
error_reporting(0);
 ?>

<?php require_once 'config.php'; ?>

<?php
$requete = $pdo->query("SELECT * FROM projets LIMIT 3");
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
        
        <div class="container row  text-center  justify-content-center mt-0  "  >           


            <div class="col  "  >
              
              <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-touch="true" >
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
               <div class="carousel-inner">
                  <?php foreach($projets as $index => $projet): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                      <img src="<?= htmlspecialchars($projet['image']) ?>" class="d-block mx-auto" style="width: 600px; height: 500px; object-fit: contain;" alt="<?= htmlspecialchars($projet['titre']) ?>">
                    </div>
                  <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon  " aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                  <span class="carousel-control-next-icon " aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

            </div>

            <h2 class="projetsreal">Projets Réalisés</h2>
            
            <span class="mb-5 mt-4 "><a class="btncta1 " href="portfolio.php"  style="text-decoration: none">Voir nos préstations</a></span>
        </div>

        <div class="secondfond container-fluid text-center p-4 " >

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d89608.42339768977!2d4.284067070562757!3d45.42419481215893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f5abff0dcfe415%3A0x631b2db87635756!2sSaint-%C3%89tienne!5e0!3m2!1sfr!2sfr!4v1743547428777!5m2!1sfr!2sfr"
                    height="400px"
                    style="border: 3px solid #F4EDE4; max-width: 90%;margin: 25px; border-radius: 15px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    >
            </iframe>
          
        </div>
        
        
        <div class="container-fluid row text-center p-5 justify-content-center" >
          
          
            <div class="col-sm-8">
              <h2 id="contact" class="mb-3">Contactez-nous</h2>
              <p class="lead mb-5">
                Pour une demande, un devis ou un rendez-vous.
              </p>
            </div>
          
            <form id="form-index" class="col-sm-8" style="width: 65%" action="traitement.php" method="POST">
              
              <div class="mb-3">
                <label class="form-label fw-bold">Vous êtes :</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="statut" id="particulier" value="Particulier" required>
                  <label class="form-check-label" for="particulier">Particulier</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="statut" id="professionnel" value="Professionnel" required>
                  <label class="form-check-label" for="professionnel">Professionnel</label>
                </div>
              </div>
  
              <div class="row">

                <div class="col  mb-3 ">                  
                  <input type="text" name="prenom" pattern="^[A-Za-zÀ-ÿ' -]+$" maxlength="40" title="Seules les lettres, accents, espaces, tirets ou apostrophes sont autorisés." class="form-control inform"  placeholder="Prénom" required>                               
                </div>

                <div class="col  mb-3">                  
                  <input type="text" name="nom"  pattern="^[A-Za-zÀ-ÿ' -]+$" maxlength="40" title="Seules les lettres, accents, espaces, tirets ou apostrophes sont autorisés." class="form-control inform"  placeholder="Nom" required>                  
                </div>

              </div>
              
              <div class="mb-3 ">                
                <input type="email" name="email" class="form-control inform"  placeholder="Adresse email" required>                
              </div>
              
              <div class="mb-3">
                <textarea name="message" maxlength="1000" class="form-control inform"  rows="6" placeholder="Votre message..." required></textarea>                            
              </div>
              
              <div class="form-check text-start mt-3">
                <input class="form-check-input" type="checkbox" id="rgpd" required>
                <label class="form-check-label small" for="rgpd">
                  J’accepte que mes données soient utilisées pour être contacté(e) dans le cadre de ma demande. <a href="politique.html" target="_blank" class="text-decoration-underline">Voir notre politique de confidentialité</a>.
                </label>
              </div>

              <div>
                <button class="btncta mt-3"  type="submit">Envoyer</button>
              </div>
              
            </form>
          

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