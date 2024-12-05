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
    /**
     * Called to check a condition to proceed the request
     * 
     * Must return true if user can proceed, or return a array with route to redirect and error message
     * 
     * Example usage:
     * public function handle() {
     *     if(!Auth::isLoggedIn()) {
     *           return [
     *               "redirect" => "/",
     *               "message" => "You must be logged in.",
     *           ];
     *     }
     *   
     *     return true;
     * }
     * 
     * @return true | []
     */
    abstract public function handle();
}