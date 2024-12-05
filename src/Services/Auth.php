<?php

namespace App\Services;

use App\Database\Database;

class Auth {
    public static function login($email, $password, Database $db) {
        $user = $db->selectSingleModel("user", [], ["email" => $email]);

        if(password_verify($password, $user["password"])) {
            session_regenerate_id(true);
            $user["logged_in"] = true;
            $_SESSION["user"] = $user;

            return true;
        }

        return false;
    }

    public static function isLoggedIn() {
        if(!isset($_SESSION["user"]) || !$_SESSION['user']['logged_in']) {
            return false;
        }

        return true;
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function user() {
        return $_SESSION["user"];
    }
}