<?php

namespace App\Database\Migrations;

use App\Database\Migrations\PostMigration;
use App\Database\Migrations\UserMigration;

class MigrationsManager {
    private $migrations = [];

    /**
     * Set all migrations to run or to be droped
     */
    public function __construct() {
        $this->migrations = [
            new UserMigration(),
            new PostMigration()
        ];
    }

    /**
     * Drop all tables from each migration
     */
    public function drop() {
        foreach($this->migrations as $migration) {
            $name = basename(str_replace('\\', '/',get_class($migration)));
            
            try {
                $migration->drop();
                echo "\033[32m" . $name . " dropped with success!\033[0m\n";
            } catch (\PDOException $e) {
                echo "\033[31mError dropping " . $name . ": " . $e->getMessage() . "\033[0m\n";
            }
        }
    }

    /**
     * Run all migrations inside the migrations array
     */
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
