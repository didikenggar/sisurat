<?php

namespace App\Core;

final class ErrorHandler
{
    public static function register(): void
    {
        set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
            if (!(error_reporting() & $severity)) {
                return false;
            }

            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        set_exception_handler(function (\Throwable $exception): void {
            http_response_code(500);
            echo '<h1>500 - Terjadi kesalahan server</h1>';
            echo '<pre>' . e($exception->getMessage()) . '</pre>';
        });
    }
}
