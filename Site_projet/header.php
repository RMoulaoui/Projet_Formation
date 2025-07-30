<?php ini_set('display_errors', 0); ?>

<?php $page = $page ?? ''; ?>

<header>
  <div class="d-sm-flex menu1 position-relative">
    <h3 class="p-2">
      <a href="index.php" class="text-white" style="text-decoration: none;">
        <i class="bi bi-palette-fill m-2"></i>Decopaint
      </a>
    </h3>
    
    <ul class="flex-column d-none d-sm-flex flex-sm-row list-unstyled mx-2">
  <li class="list-item mx-2 p-sm-0">
    <a href="index.php" class="link-light <?= $page === 'accueil' ? 'fw-bold text-decoration-none' : '' ?>">
      <i class="bi bi-house-fill m-2"></i>Accueil
    </a>
  </li>
  <li class="list-item mx-2 p-sm-0">
    <a href="portfolio.php" class="link-light <?= $page === 'portfolio' ? 'fw-bold text-decoration-none' : '' ?>">
      <i class="bi bi-book-half m-2"></i>Portfolio
    </a>
  </li>
  <li class="list-item mx-2 pb-2 p-sm-0">
    <a href="contact.php" class="link-light <?= $page === 'contact' ? 'fw-bold text-decoration-none' : '' ?>">
      <i class="bi bi-envelope-at-fill m-2"></i>Contact
    </a>
  </li>
</ul>

    <button class="btn btn-light btn-sm position-absolute top-50 translate-middle-y d-sm-none me-2"
        style="right: 0; margin-top: 2px; padding: 4px 8px;"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasMenu"
        aria-controls="offcanvasMenu">
  <i class="bi bi-list fs-5"></i>
</button>




  </div>
</header>

<!-- Menu Offcanvas Mobile -->
<div class="offcanvas offcanvas-end bg-dark text-white" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled">
      <li class="mb-3">
        <a href="index.php" class="text-white <?= $page === 'accueil' ? 'fw-bold text-decoration-none' : '' ?>">
          <i class="bi bi-house-fill me-2"></i>Accueil
        </a>
      </li>
      <li class="mb-3">
        <a href="portfolio.php" class="text-white <?= $page === 'portfolio' ? 'fw-bold text-decoration-none' : '' ?>">
          <i class="bi bi-book-half me-2"></i>Portfolio
        </a>
      </li>
      <li>
        <a href="contact.php" class="text-white <?= $page === 'contact' ? 'fw-bold text-decoration-none' : '' ?>">
          <i class="bi bi-envelope-at-fill me-2"></i>Contact
        </a>
      </li>
    </ul>
  </div>
</div>

