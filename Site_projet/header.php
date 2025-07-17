<?php ini_set('display_errors', 0); ?>

<?php $page = $page ?? ''; ?>
<header>
  <div class="d-sm-flex menu1 position-relative">
    <h3 class="p-2">
      <a href="index.php" class="text-white" style="text-decoration: none;">
        <i class="bi bi-palette-fill m-2"></i>Decopaint
      </a>
    </h3>
    <ul id="collapseMenu" class="flex-column d-sm-flex flex-sm-row collapse list-unstyled mx-2">
      <li class="list-item mx-2 p-sm-0">
        <a href="index.php" class="<?= $page === 'accueil' ? 'nav-disabled' : 'linkhover link-light' ?>">
          <i class="bi bi-house-fill m-2"></i>Accueil
        </a>
      </li>
      <li class="list-item mx-2 p-sm-0">
        <a href="portfolio.php" class="<?= $page === 'portfolio' ? 'nav-disabled' : 'linkhover link-light' ?>">
          <i class="bi bi-book-half m-2"></i>Portfolio
        </a>
      </li>
      <li class="list-item mx-2 pb-2 p-sm-0">
        <a href="contact.php" class="<?= $page === 'contact' ? 'nav-disabled' : 'linkhover link-light' ?>">
          <i class="bi bi-envelope-at-fill m-2"></i>Contact
        </a>
      </li>
    </ul>
    <a class="btn btn-light position-absolute top-0 end-0 m-2 d-sm-none" data-bs-toggle="collapse" href="#collapseMenu">
      <i class="bi bi-list"></i>
    </a>
  </div>
</header>
