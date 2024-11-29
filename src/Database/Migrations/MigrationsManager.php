<?php

namespace App\Database\Migrations;

use App\Database\Migrations\PostMigration;
use App\Database\Migrations\UserMigration;

class MigrationsManager {
    private $migrations = [];

    public function __construct() {
        $this->migrations = [
            new UserMigration(),
            new PostMigration()
        ];
    }

    public function run() {
        foreach($this->migrations as $migration) {
            $name = basename(str_replace('\\', '/',get_class($migration)));
            
            try {
                $migration->migrate();
                echo "\033[32m" . $name . " executed with success!\033[0m\n";
            } catch (\PDOException $e) {
                echo "\033[31mError executing " . $name . ": " . $e->getMessage() . "\033[0m\n";
            }
        }
    }
}
