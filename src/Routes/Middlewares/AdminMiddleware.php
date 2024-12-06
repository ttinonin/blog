<?php

namespace App\Routes\Middlewares;

use App\Services\Auth;
use App\Routes\Middlewares\Middleware;

class AdminMiddleware extends Middleware {
    public function handle() {   
        $user = Auth::user();

        if(intval($user["is_admin"]) === 0) {
            return [
                "redirect" => "/",
                "message" => "Only admins can proceed.",
            ];
        }

        return true;
    }
}