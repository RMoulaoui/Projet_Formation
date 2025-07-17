<?php ini_set('display_errors', 0); ?>

<?php $page = $page ?? ''; ?>
<footer class="bg-black text-white text-center p-3 mt-auto">
  <p class="m-0">&copy; 2025 Decopaint. Tous droits réservés.</p>
  <p class="m-0 small">
    <a href="mentions-legales.php"
       class="<?= $page === 'mentions' ? 'nav-disabled' : 'text-white text-decoration-underline' ?>">
      Mentions légales 
    </a> |
    <a href="politique.php"
       class="<?= $page === 'politique' ? 'nav-disabled' : 'text-white text-decoration-underline' ?>">
       Politique de confidentialité 
    </a> |
    <a href="admin/login.php"
       class="<?= $page === 'admin' ? 'nav-disabled' : 'text-white text-decoration-underline' ?>">
       Admin
    </a>
  </p>
</footer>
