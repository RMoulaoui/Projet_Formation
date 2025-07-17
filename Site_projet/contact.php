<?php ini_set('display_errors', 0); ?>

<!doctype html>

<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Decopaint - Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    

  </head>

  
  <body class="contact-page">

    <div class="main-content ">

    <!-- Header -->
    <?php
      $page = 'contact'; 
      include 'header.php';
    ?>
      
    <!-- Contenu -->

      <div class="blocprincipal d-flex  flex-grow-1 g-0 m-0">
          
        <div class="carte d-flex col-12 col-sm-6 justify-content-center align-items-center  fondcontact order-sm-1 order-2" >
            <div class="container text-center justify-content-center ">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5596.921601669106!2d4.384563090882438!3d45.460520659109584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f5ac72b5162507%3A0x8082a74595924a0a!2sStade%20Geoffroy-Guichard!5e0!3m2!1sfr!2sfr!4v1743540316581!5m2!1sfr!2sfr" 
                    height="450"
                    style="border: 5px solid rgb(245, 238, 230); padding: 4px; border-radius: 30px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
        
        
        <div class="formulaire d-flex flex-column col-12 col-sm-6 text-center justify-content-center order-sm-2 order-1 "  >
            
                <div class="col-sm-8">
                  <h1 id="contact" class="mb-3">Contactez-nous</h1>
                  <p class="lead mb-5">
                    Pour une demande, un devis ou un rendez-vous.
                  </p>
                </div>

              <form id="form-contact" class="mx-auto col-12 col-sm-10 col-md-6 px-3" style="max-width: 600px;" action="traitement.php" method="POST" >
                
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


                <div class="row mb-3">
                    <div class="col">
                    <input type="text" name="prenom" class="form-control inform" placeholder="Prénom" pattern="^[A-Za-zÀ-ÿ -]+$" title="Seules les lettres, espaces et tirets sont autorisés" maxlength="40" inputmode="text" required>
                    </div>
                    <div class="col">
                    <input type="text" name="nom" class="form-control inform" placeholder="Nom" pattern="^[A-Za-zÀ-ÿ -]+$" title="Seules les lettres, espaces et tirets sont autorisés" maxlength="40" inputmode="text" required>
                    </div>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control inform" placeholder="Adresse email" required>
                </div>

                <div class="mb-3">
                    <textarea name="message" class="form-control inform" placeholder="Votre message..." rows="6" maxlength="1000" required></textarea>
                </div>

                <div class="form-check text-start mt-3">
                  <input class="form-check-input" type="checkbox" id="rgpd" required>
                  <label class="form-check-label small" for="rgpd">
                    J’accepte que mes données soient utilisées pour être contacté(e) dans le cadre de ma demande. <a href="politique.html" target="_blank" class="text-decoration-underline">Voir notre politique de confidentialité</a>.
                  </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btncta my-3">Envoyer</button>
                </div>
              </form>

            
        </div>       
    
    
      </div>
      

    </div>
    
    <!-- Footer -->

    <?php
      include 'footer.php';
    ?>
  
      

    <a class="btnup position-fixed  bottom-0 end-0 bouton p-2 m-2 border border-light" href="#" ><i class="text-light bi bi-chevron-double-up"></i></a>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/script.js"></script>


  </body>
  
</html>