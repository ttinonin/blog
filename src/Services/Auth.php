<?php

namespace App\Services;

use App\Database\Database;

class Auth {
    /**
     * Authenticate the user into the application
     * 
     * Example usage:
     * if(!Auth::login($email, $password, $this->db)) {
     *     Redirect::back();
     * }
     * 
     * @param string $email User email
     * @param string $password Password from the request
     * @param Database $db Database instance reference
     * @return true|false
     */
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

    /**
     * Checks if user is logged in
     * 
     * Example usage:
     * if(!Auth::isLoggedIn()) {
     *     Redirect::back();
     * }
     * 
     * @return true|false
     */
    public static function isLoggedIn() {
        if(!isset($_SESSION["user"]) || !$_SESSION['user']['logged_in']) {
            return false;
        }

        return true;
    }

    /**
     * Logout the user.
     */
    public static function logout() {
        session_unset();
        session_destroy();
    }

    /**
     * Returns logged in user data
     * 
     * @return array|null
     */
    public static function user() {
        if(isset($_SESSION["user"])) {
            return $_SESSION["user"];
        }

        return null;
    }
}