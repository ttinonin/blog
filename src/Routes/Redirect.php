<?php

namespace App\Routes;

class Redirect {
    
    public static function redirect($url, $data = []) {
        $BASE_URL = "/php/blog";
        
        if (!empty($data)) {
            $_SESSION['flash_data'] = $data;
        }

        header('Location: ' . $BASE_URL . $url, true);
        exit();
    }

    public static function back() {
        header('Location: ' . $_SERVER['HTTP_REFERER'], true);
        exit();
    }

    public static function getFlashData() {
        if (isset($_SESSION['flash_data'])) {
            $data = $_SESSION['flash_data'];
            unset($_SESSION['flash_data']);
            return $data;
        }

        return null;
    }
}