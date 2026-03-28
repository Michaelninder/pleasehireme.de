<?php
require_once dirname(__DIR__) . '/bootstrap.php';

$router  = new Router();
$request = new Request();

// ── Routes ────────────────────────────────────────────────────────────────────

$router->get('/', function () {
    require_once DATA_FILE;
    $title   = 'Please hire me (.de)';
    ob_start();
    require VIEWS . '/home.php';
    $content = ob_get_clean();
    require VIEWS . '/layout.php';
});

$router->get('/imprint', function () {
    require VIEWS . '/imprint.php';
});

$router->get('/img', function (Request $req) {
    // Proxy to img.php at root
    require ROOT . '/img.php';
});

// ── Dispatch ──────────────────────────────────────────────────────────────────

$router->dispatch($request);
