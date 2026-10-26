<?php

namespace App\Core;

final class Request
{
    public function __construct(
        public readonly array $server,
        public readonly array $query,
        public readonly array $post,
        public readonly array $files,
        public readonly array $cookies
    ) {
    }

    public static function fromGlobals(): self
    {
        return new self(
            $_SERVER,
            $_GET,
            $_POST,
            $_FILES,
            $_COOKIE
        );
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }
}
