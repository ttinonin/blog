<?php

namespace App\Services\Policies;

use App\Services\Auth;

class PostPolicy {
    public static function can_create() {
        $user = Auth::user();

        if($user === null) {
            return false;
        }

        if(intval($user["is_admin"]) === 1) {
            return true;
        }

        return false;
    }
}