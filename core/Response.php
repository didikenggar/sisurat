<?php

namespace App\Core;

final class Response
{
    public function __construct(
        private int $status = 200,
        private string $body = '',
        private array $headers = []
    ) {
    }

    public static function redirect(string $location, int $status = 302): self
    {
        $response = new self($status);
        $response->headers['Location'] = $location;
        return $response;
    }

    public static function html(string $html, int $status = 200): self
    {
        return new self($status, $html, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
        echo $this->body;
    }
}
