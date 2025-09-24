<?php
require_once __DIR__ . '/_session.php';

if (empty($_SESSION['admin_connecté']) || $_SESSION['admin_connecté'] !== true) {
    header('Location: login.php'); exit;
}
require_once __DIR__ . '/../../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT id, titre FROM projets WHERE id = :id');
$stmt->execute([':id' => $id]);
$projet = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$projet) { http_response_code(404); exit('Projet introuvable'); }
?>

<!doctype html>
<meta charset="utf-8">
<title>Confirmer la suppression</title>
<style>
  body{font-family:sans-serif;background:#F4EDE4;color:#232;margin:0;padding:2rem}
  .card{background:#fff;max-width:560px;margin:auto;padding:1.25rem;border-radius:10px;box-shadow:0 2px 14px rgba(0,0,0,.08)}
  .actions{margin-top:1rem;display:flex;gap:.5rem}
  .btn{padding:.5rem .9rem;border-radius:.5rem;border:1px solid transparent;cursor:pointer}
  .btn-danger{background:#dc3545;color:#fff;border-color:#dc3545}
  .btn-secondary{background:#e9ecef;color:#111;border-color:#ced4da;text-decoration:none}
</style>

<div class="card">
  <h1 style="margin:0 0 .75rem;font-size:1.1rem;color:#1E3A5F">Confirmer la suppression</h1>
  <p>Supprimer « <strong><?= htmlspecialchars($projet['titre'], ENT_QUOTES, 'UTF-8') ?></strong> » ? Cette action est irréversible.</p>
  <form method="post" action="supprimer.php" class="actions">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="id" value="<?= (int)$projet['id'] ?>">
    <button type="submit" class="btn btn-danger">Oui, supprimer</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
  </form>
</div>
