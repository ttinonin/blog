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
    /**
     * Get data from GET requests
     * 
     * Example usage:
     * Request::get('search');
     * 
     * @param $param Param from form field
     */
    public static function get($param) {
        $data = $_GET[$param];

        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Get data from POST requests
     * 
     * Example usage:
     * Request::get('email');
     * 
     * @param $param Param from form field
     */
    public static function post($param) {
        $data = $_POST[$param];

        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}