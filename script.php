<?php
const FOURNISSEUR = ['scheme' => 'http', 'host' => 'localhost', 'port' => 8002];

function url_autorisee(string $url): bool {
    $morceaux = parse_url($url);
    if ($morceaux === false) {
        return false;
    }
    return ($morceaux['scheme'] ?? '') === FOURNISSEUR['scheme']
        && ($morceaux['host'] ?? '') === FOURNISSEUR['host']
        && ($morceaux['port'] ?? 0) === FOURNISSEUR['port']
        && !isset($morceaux['user'])
        && !isset($morceaux['pass']);
}

$urls = [
    'a' => 'http://localhost:8002/couvertures/germinal.png',
    'b' => 'https://localhost:8002/couvertures/germinal.png',
    'c' => 'http://localhost:8002@127.0.0.1:8001/config.php',
    'd' => 'http://LOCALHOST:8002/couvertures/germinal.png',
    'e' => 'http://localhost/couvertures/germinal.png',
    'f' => 'http://localhost:8002.attaquant.example/',
    'g' => 'http://localhost:8002/redirection.php?vers=http://127.0.0.1:8001/config.php',
];

foreach ($urls as $lettre => $u) {
    $p = parse_url($u);
    echo $lettre, ' | hôte : ', $p['host'] ?? '(aucun)', ' | ',
         url_autorisee($u) ? 'ACCEPTÉE' : 'refusée', PHP_EOL;
}