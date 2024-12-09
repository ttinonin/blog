<?php

namespace Utils;

use Exception;

class Environment {
    public static function load($file_path) {
        if (!file_exists($file_path)) {
            throw new Exception(".env file not found: {$file_path}");
        }
    
        $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
    
            [$key, $value] = explode('=', $line, 2);
    
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
    
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}