<?php

namespace App\Routes;

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