<?php

declare(strict_types=1);

require __DIR__ . '/../core/helpers.php';

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require dirname(__DIR__) . '/vendor/autoload.php';
} else {
    spl_autoload_register(static function (string $class): void {
        $relative = str_replace('App\\', '', $class);
        $path = __DIR__ . '/../' . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    });
}

use App\Core\Auth;
use App\Core\Database;
use App\Core\ErrorHandler;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;

Session::start();
ErrorHandler::register();

$database = Database::boot();
$database->ensureSchema();

$auth = new Auth($database);
$request = Request::fromGlobals();
$route = Router::dispatch($request, $auth);

if ($route instanceof Response) {
    $route->send();
    exit;
}

$view = new View(dirname(__DIR__));
$view->render($route['view'] ?? 'modules/dashboard/views/index', $route['data'] ?? []);
