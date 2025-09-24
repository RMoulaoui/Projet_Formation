<?php
// À inclure en TÊTE de chaque page admin AVANT tout output
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);

$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

// Paramètres cookie (PHP ≥ 7.3)
session_set_cookie_params([
  'lifetime' => 0,
  'path'     => '/',
  'domain'   => '',
  'secure'   => $https,      // true si site force HTTPS 
  'httponly' => true,
  'samesite' => 'Strict',    // 'Lax' si redirections cross-site
]);


session_name('decopaint_admin'); // nom dédié
session_start();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if (!empty($_SESSION['admin_connecté'])) {
    // Timeout d'inactivité (30 min)
    if (isset($_SESSION['last_seen']) && time() - $_SESSION['last_seen'] > 1800) {
        session_unset();
        session_destroy();
        header('Location: login.php?timeout=1');
        exit;
    }
    $_SESSION['last_seen'] = time();

    if (empty($_SESSION['sid_rotated_at'])) {
        $_SESSION['sid_rotated_at'] = time();
    }
    if (time() - $_SESSION['sid_rotated_at'] > 600) { // toutes les 10 min
        session_regenerate_id(true);
        $_SESSION['sid_rotated_at'] = time();
    }


    // Verrouillage léger sur l'UA (et IP tronquée)
    if (!isset($_SESSION['ua_hash'])) {
        $_SESSION['ua_hash'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
        $_SESSION['ip_octets'] = implode('.', array_slice(explode('.', $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 3));
    } else {
        $ua_ok = hash_equals($_SESSION['ua_hash'], hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? ''));
        if (!$ua_ok) {
            session_unset();
            session_destroy();
            header('Location: login.php?session=ua_mismatch');
            exit;
        }
    }
}

// --- CSRF helpers ---
if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }
}
if (!function_exists('csrf_check')) {
    function csrf_check(string $token): bool {
        return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
    }
}


