<?php
/*
 * MIT License
 * Copyright (c) 2024 Thiago Monteiro Tinonin
 * 
 * See the LICENSE file for more information.
*/

ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');

require __DIR__ . "/../vendor/autoload.php";

use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Routes\Router;

$router = new Router();

$router->add('GET', '/', [UserController::class, "home"]);

// User related routes
$router->add('GET', '/create-user', [UserController::class, "create_form"]);
$router->add('POST', '/user', [UserController::class, "create"]);
$router->add('GET', '/user/{id}', [UserController::class, "read"]);

// Auth related routes
$router->add('GET', '/sign-in', [UserController::class, "sign_in_form"]);
$router->add('POST', '/sign-in', [UserController::class, "sign_in"]);
$router->add('POST', '/logout', [UserController::class, "logout"], ["auth"]);

// Post related routes
$router->add('GET', '/create-post', [PostController::class, "create_form"], ["auth", "admin"]);
$router->add('POST', '/post', [PostController::class, "create"], ["auth", "admin"]);
$router->add('GET', '/post/{id}', [PostController::class, "read"]);
$router->add('GET', '/posts', [PostController::class, "read_all"]);
$router->add('POST', '/delete-post/{id}', [PostController::class, "delete"], ["auth", "admin"]);

$router->run(); 