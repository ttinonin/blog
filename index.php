<?php

require __DIR__ . "/vendor/autoload.php";

use App\Controllers\UserController;
use App\Routes\Router;

$BASE_PATH = "/php/blog";

$router = new Router();
$router->add('GET', $BASE_PATH . '/create-user', [UserController::class, "create_form"]);
$router->add('POST', $BASE_PATH . '/user', [UserController::class, "create"]);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($path); 