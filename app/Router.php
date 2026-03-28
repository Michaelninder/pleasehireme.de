<?php

class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(Request $request): void
    {
        $method  = $request->method;
        $path    = $request->path;

        // Serve static assets from root/assets/
        if (str_starts_with($path, '/assets/')) {
            $this->serveStatic($path);
            return;
        }

        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            $this->abort(404);
            return;
        }

        call_user_func($handler, $request);
    }

    private function serveStatic(string $path): void
    {
        $resolved = realpath(ROOT . $path);
        $assetsRoot = realpath(ROOT . '/assets');

        // Security: must resolve and stay inside ROOT/assets
        if ($resolved === false || !str_starts_with($resolved, $assetsRoot)) {
            $this->abort(403);
            return;
        }

        if (!is_file($resolved)) {
            $this->abort(404);
            return;
        }

        $ext  = strtolower(pathinfo($resolved, PATHINFO_EXTENSION));
        $mime = match($ext) {
            'css'         => 'text/css',
            'js'          => 'application/javascript',
            'png'         => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif'         => 'image/gif',
            'webp'        => 'image/webp',
            'svg'         => 'image/svg+xml',
            'ico'         => 'image/x-icon',
            'woff'        => 'font/woff',
            'woff2'       => 'font/woff2',
            'ttf'         => 'font/ttf',
            default       => 'application/octet-stream',
        };

        header('Content-Type: ' . $mime);
        header('Cache-Control: public, max-age=2592000');
        header('Content-Length: ' . filesize($resolved));
        readfile($resolved);
        exit;
    }

    public function abort(int $code): void
    {
        http_response_code($code);
        require VIEWS . '/error.php';
        exit;
    }
}
