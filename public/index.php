<?php
require_once dirname(__DIR__) . '/bootstrap.php';

// ── Locale ────────────────────────────────────────────────────────────────────
if (isset($_GET['lang'])) {
    $locale = $_GET['lang'];
    setcookie('lang', $locale, time() + 31536000, '/');
} elseif (isset($_COOKIE['lang'])) {
    $locale = $_COOKIE['lang'];
} else {
    $locale = Lang::detectLocale();
}
Lang::init($locale);

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

$router->get('/img', function () {
    require ROOT . '/img.php';
});

// ── Dispatch ──────────────────────────────────────────────────────────────────

$router->dispatch($request);
