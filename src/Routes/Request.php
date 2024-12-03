<?php

namespace App\Routes;

/**
 * Request is a class to prevent XSS
 * 
 * Request is a class to prevent XSS atacks from form fields
 * 
 * Example usage:
 * $username = Request::post('username');
 */
class Request {
    public static function get($param) {
        $data = $_GET[$param];

        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public static function post($param) {
        $data = $_POST[$param];

        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}