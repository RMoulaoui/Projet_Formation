<?php ini_set('display_errors', 0); ?>
<?php $page = $page ?? ''; ?>

<footer class="secondfond text-clair pt-4">
  <div class="container">
    <div class="row text-center text-md-start align-items-start">

  <!-- Colonne 1 : Carte & Adresse -->
  <div class="col-md-3 mb-4 text-center">
    <h5 class="fw-bold mb-3">Où nous trouver</h5>
    <p class=" mt-2 mb-0 small">
      14 Rue Paul et Pierre Guichard<br>42000 Saint-Étienne, France
    </p><br>
    <div class="map-container mx-auto" style="max-width: 250px;">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2798.4607971331534!2d4.386859076652695!3d45.46052073368363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f5ac72b5162507%3A0x8082a74595924a0a!2sStade%20Geoffroy-Guichard!5e0!3m2!1sfr!2sfr!4v1753727090328!5m2!1sfr!2sfr" width="100%" height="150" style="border:0; border-radius:6px;" allowfullscreen loading="lazy"></iframe>
    </div>
  </div>

  <!-- Colonne 2 : Contact -->
  <div class="col-md-3 mb-4 text-center">
    <h5 class="fw-bold mb-3">Contact</h5>
    <p class="mb-1">
      <a href="tel:+33412345678" class="text-white text-decoration-none">+33 4 12 34 56 78</a>
    </p>
    <p>
      <a href="contact.php" class="btn btn-outline-light btn-sm mt-2">Formulaire de contact</a>
    </p>
  </div>

  <!-- Colonne 3 : Newsletter -->
  <div class="col-md-3 mb-4 text-center">
    <h5 class="fw-bold mb-3">Newsletter</h5>
    <form action="#" method="post" class="mx-auto" style="max-width: 250px;">
      <div class="input-group">
        <input type="email" class="form-control form-control-sm" placeholder="Votre email" required>
        <button class="btn btn-light btn-sm" type="submit">OK</button>
      </div>
    </form>
  </div>

  <!-- Colonne 4 : Liens légaux -->
  <div class="col-md-3 mb-4 text-center">
    <h5 class="fw-bold mb-3">Liens utiles</h5>
    <p class="mb-1">
      <a href="mentions-legales.php" class="text-white <?= $page === 'mentions' ? 'fw-bold text-decoration-none' : 'text-decoration-underline' ?>">Mentions légales</a>
    </p>
    <p class="mb-1">
      <a href="politique.php" class="text-white <?= $page === 'politique' ? 'fw-bold text-decoration-none' : 'text-decoration-underline' ?>">Politique de confidentialité</a>
    </p>
  </div>

</div>

    <!-- Ligne séparatrice -->
    <hr class="border-light">

    <!-- Bas du footer -->
    <div class="text-center pb-2">
      <small>&copy; 2025 Decopaint. Tous droits réservés.</small>
    </div>
  </div>
</footer>
