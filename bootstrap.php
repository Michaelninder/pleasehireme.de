<?php

define('ROOT',      __DIR__);
define('APP',       ROOT . '/app');
define('VIEWS',     ROOT . '/views');
define('DATA_FILE', ROOT . '/data.php');

// Simple PSR-4-style autoloader for app/
spl_autoload_register(function (string $class): void {
    $file = APP . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Global error → view bridge
set_error_handler(function (int $errno, string $errstr): bool {
    if (!(error_reporting() & $errno)) return false;
    http_response_code(500);
    require VIEWS . '/error.php';
    exit;
});
