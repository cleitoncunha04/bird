<?php

use Cleitoncunha\Bird\Controller\Error404Controller;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../config/routes.php';

/** @var ContainerInterface $diContainer */
$diContainer = require __DIR__ . '/../config/dependencies.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

session_set_cookie_params(
    [
        'lifetime' => 3600,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ]
);

session_start();

session_regenerate_id(true);

$isAuthRoute = in_array($pathInfo, ['/login', '/signup']);

if (!array_key_exists('logged', $_SESSION) && !$isAuthRoute) {
    header('Location: /login');

    return;
}

if (array_key_exists("$httpMethod|$pathInfo", $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    $controller = $diContainer->get($controllerClass);
} else {
    $controller = new Error404Controller();
}

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
);

// passa as variaveis, como $_POST, $_GET, $_FILES, $_COOKIES, etc.
$request = $creator->fromGlobals();

/** @var RequestHandlerInterface $controller */
$response = $controller->handle($request);

$response->getHeaders();

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $header => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $header, $value), false);
    }
}

echo $response->getBody();
