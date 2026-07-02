<?php
declare(strict_types=1);

$debug = filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOLEAN);
ini_set('display_errors', $debug ? '1' : '0');
ini_set('display_startup_errors', $debug ? '1' : '0');
error_reporting(E_ALL);

header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

spl_autoload_register(function (string $class): void {
    $class = str_replace('App\\', '', $class);
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../app/' . $class . '.php';

    if (is_file($file)) {
        require $file;
    }
});

use App\Controllers\SiteController;
use App\Controllers\AdminController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$site = new SiteController();
$admin = new AdminController();

if ($uri === '/') {
    $site->home();
} elseif (preg_match('#^/project/([a-zA-Z0-9\-]+)$#', $uri, $match)) {
    $site->project($match[1]);
} elseif ($uri === '/admin/login' && $method === 'GET') {
    $admin->login();
} elseif ($uri === '/admin/login' && $method === 'POST') {
    $admin->authenticate();
} elseif ($uri === '/admin') {
    $admin->dashboard();
} elseif ($uri === '/admin/projects/new') {
    $admin->create();
} elseif ($uri === '/admin/projects/store' && $method === 'POST') {
    $admin->store();
} elseif (preg_match('#^/admin/projects/(\d+)/edit$#', $uri, $match)) {
    $admin->edit((int) $match[1]);
} elseif (preg_match('#^/admin/projects/(\d+)/update$#', $uri, $match) && $method === 'POST') {
    $admin->update((int) $match[1]);
} elseif (preg_match('#^/admin/projects/(\d+)/delete$#', $uri, $match) && $method === 'POST') {
    $admin->delete((int) $match[1]);
} elseif ($uri === '/admin/logout' && $method === 'POST') {
    $admin->logout();
} else {
    http_response_code(404);
    echo 'Page not found';
}
