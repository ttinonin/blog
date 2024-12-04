<?php

namespace App\Services;

use App\Database\Database;

class Auth {
    public static function login($email, $password, Database $db) {
        $user = $db->selectSingleModel("user", [], ["email" => $email]);

        if(password_verify($password, $user["password"])) {
            $user["logged_in"] = true;
            $_SESSION["user"] = $user;

            return true;
        }

        return false;
    }

    public static function isLoggedIn() {
        if(!isset($_SESSION["user"]) || !$_SESSION['user']['logged_in']) {
            return true;
        }

        return false;
    }
}