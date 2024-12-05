<?php

namespace App\Routes\Middlewares;

/**
 * Middleware is a abstract class
 * 
 * Every middleware must extends the Middleware class, to follow basic functions to be used inside the manager.
 * 
 * Example usage:
 * class AuthMiddleware extends Middleware {}
 */
abstract class Middleware {
    abstract public function handle();
}