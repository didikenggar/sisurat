<?php

namespace App\Core;

use App\Config\Routes;

final class Router
{
    public static function dispatch(Request $request, Auth $auth): mixed
    {
        $method = $request->method();
        $uri = $request->uri();
        $path = $uri === '' ? '/' : $uri;

        foreach (Routes::all() as $route) {
            [$httpMethod, $pattern, $handler, $middleware] = $route;
            if ($httpMethod !== $method) {
                continue;
            }

            $params = self::match($pattern, $path);
            if ($params === null) {
                continue;
            }

            if (self::requiresAuth($middleware)) {
                if (!$auth->check()) {
                    return Response::redirect('/login');
                }

                $requiredRoles = array_values(array_filter($middleware, static fn (string $role): bool => $role !== 'auth'));
                if ($requiredRoles !== [] && !$auth->hasAnyRole($requiredRoles)) {
                    return Response::html(self::forbiddenPage(), 403);
                }
            }

            [$class, $methodName] = $handler;
            $controller = new $class();
            $result = $controller->$methodName($request, $params, $auth);
            if ($result instanceof Response) {
                return $result;
            }

            return $result;
        }

        return Response::html('<h1>404 - Halaman tidak ditemukan</h1>', 404);
    }

    private static function match(string $pattern, string $path): ?array
    {
        preg_match_all('/\{([^}]+)\}/', $pattern, $keys);
        $regexPattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        $regexPattern = '#^' . $regexPattern . '$#';

        if (preg_match($regexPattern, $path, $matches)) {
            array_shift($matches);
            $named = [];
            foreach ($keys[1] as $index => $key) {
                $named[$key] = $matches[$index] ?? null;
            }
            return $named;
        }

        return null;
    }

    private static function requiresAuth(array $middleware): bool
    {
        return in_array('auth', $middleware, true);
    }

    private static function forbiddenPage(): string
    {
        return '<html><body><h1>403 - Akses ditolak</h1><p>Anda tidak memiliki hak untuk halaman ini.</p></body></html>';
    }
}
