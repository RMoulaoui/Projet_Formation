<?php
function charger_env($chemin = __DIR__ . '/.env') {
    if (!file_exists($chemin)) {
        return [];
    }

    $lignes = file($chemin, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];

    foreach ($lignes as $ligne) {
        if (strpos(trim($ligne), '#') === 0) continue; // ignore les commentaires
        list($cle, $valeur) = explode('=', $ligne, 2);
        $env[trim($cle)] = trim($valeur);
    }

    return $env;
}
?>
