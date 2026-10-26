<?php

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('url')) {
    function url(string $path): string
    {
        $path = ltrim($path, '/');
        return '/' . $path;
    }
}

if (!function_exists('current_user')) {
    function current_user(): ?array
    {
        return App\Core\Session::get('user');
    }
}
