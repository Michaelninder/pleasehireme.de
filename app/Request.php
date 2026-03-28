<?php

class Request
{
    public readonly string $path;
    public readonly string $method;

    public function __construct()
    {
        $uri    = $_SERVER['REQUEST_URI'] ?? '/';
        $parsed = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Normalize: always leading slash, no trailing slash except root
        $path = '/' . trim($parsed, '/');
        $this->path   = $path === '' ? '/' : $path;
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }
}
