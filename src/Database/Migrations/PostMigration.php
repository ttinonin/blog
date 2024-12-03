<?php

namespace App\Database\Migrations;

use App\Database\Migrations\Migration;

class PostMigration extends Migration {
    public function migrate() {
        $sql = "
            CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title varchar(255) NOT NULL,
                body LONGTEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

        ";

        $this->db->execute($sql);
    }
}