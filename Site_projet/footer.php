<?php ini_set('display_errors', 0); ?>

<?php $page = $page ?? ''; ?>
<footer class="secondfond text-white text-center p-3 mt-auto">
  <p class="m-0">&copy; 2025 Decopaint. Tous droits réservés.</p>
  <p class="m-0 small">
    <a href="mentions-legales.php"
       class="text-white <?= $page === 'mentions' ? 'fw-bold text-decoration-none' : 'text-decoration-underline' ?>">
      Mentions légales
    </a> |
    <a href="politique.php"
       class="text-white <?= $page === 'politique' ? 'fw-bold text-decoration-none' : 'text-decoration-underline' ?>">
      Politique de confidentialité
    </a> |
    <a href="admin/login.php"
       class="text-white <?= $page === 'admin' ? 'fw-bold text-decoration-none' : 'text-decoration-underline' ?>">
      Admin
    </a>
  </p>
</footer>
