<?php

namespace App\Core;

final class View
{
    public function __construct(private string $basePath)
    {
    }

    public function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $file = $this->basePath . '/' . ltrim($view, '/') . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException('View not found: ' . $file);
        }

        $user = $user ?? Session::get('user');

        if (!$this->shouldUseLayout($view)) {
            include $file;
            return;
        }

        ob_start();
        include $file;
        $content = ob_get_clean();

        $layoutFile = $this->basePath . '/views/layouts/app.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException('Layout not found: ' . $layoutFile);
        }

        include $layoutFile;
    }

    private function shouldUseLayout(string $view): bool
    {
        $normalized = ltrim($view, '/');
        return !str_contains($normalized, 'modules/auth/views/login')
            && !str_contains($normalized, 'modules/surat/views/print');
    }
}
