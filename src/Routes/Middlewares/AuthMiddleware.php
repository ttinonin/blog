<?php

namespace App\Routes\Middlewares;

use App\Routes\Middlewares\Middleware;
use App\Services\Auth;

class AuthMiddleware extends Middleware {
    public function handle() {
        if(!Auth::isLoggedIn()) {
            return [
                "redirect" => "/",
                "message" => "You must be logged in.",
            ];
        }
        
        return true;
    }
}