<?php

namespace App\Routes\Middlewares;

use App\Routes\Middlewares\AuthMiddleware;

/**
 * MiddlewareManager calls Middlewares basic functions
 * 
 * Every Middleware instance must be added inside the $middlewares array followed by its name.
 */
class MiddlewareManager {
    private $middlewares = [];

    public function __construct() {
        $this->middlewares = [
            "auth" => new AuthMiddleware()
        ];
    }

    public function load($middleware) {
        return $this->middlewares[$middleware]->handle();
    }
}