<?php

namespace App\Routes;

class Redirect {
    /**
     * Redirect user to a route
     * 
     * @param string $url Route to redirect
     * @param string[] $data Flash data for toasts
     * @return void
     */
    public static function redirect($url, $data = []) {
        if (!empty($data)) {
            $_SESSION['flash_data'] = $data;
        }

        header('Location: ' . $url, true);
        exit();
    }

    /**
     * Redirect user to the previous route
     * 
     * @return void
     */
    public static function back() {
        header('Location: ' . $_SERVER['HTTP_REFERER'], true);
        exit();
    }

    /**
     * Get flash data for toasts
     * 
     * @return array|null
     */
    public static function getFlashData() {
        if (isset($_SESSION['flash_data'])) {
            $data = $_SESSION['flash_data'];
            unset($_SESSION['flash_data']);
            return $data;
        }

        return null;
    }
}