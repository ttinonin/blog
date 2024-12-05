<?php

require __DIR__ . "/vendor/autoload.php";

use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Routes\Router;

$BASE_PATH = "/php/blog";

$router = new Router();

$router->add('GET', $BASE_PATH . '/', [UserController::class, "home"]);

// User related routes
$router->add('GET', $BASE_PATH . '/create-user', [UserController::class, "create_form"]);
$router->add('POST', $BASE_PATH . '/user', [UserController::class, "create"]);
$router->add('GET', $BASE_PATH . '/user/{id}', [UserController::class, "read"]);

// Auth related routes
$router->add('GET', $BASE_PATH . '/sign-in', [UserController::class, "sign_in_form"]);
$router->add('POST', $BASE_PATH . '/sign-in', [UserController::class, "sign_in"]);
$router->add('POST', $BASE_PATH . '/logout', [UserController::class, "logout"]);

// Post related routes
$router->add('GET', $BASE_PATH . '/create-post', [PostController::class, "create_form"], ["auth"]);
$router->add('POST', $BASE_PATH . '/post', [PostController::class, "create"]);
$router->add('GET', $BASE_PATH . '/post/{id}', [PostController::class, "read"]);
$router->add('GET', $BASE_PATH . '/posts', [PostController::class, "read_all"]);
$router->add('POST', $BASE_PATH . '/delete-post/{id}', [PostController::class, "delete"]);

$router->run(); 