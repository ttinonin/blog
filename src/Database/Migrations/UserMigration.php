<?php

namespace App\Database\Migrations;

use App\Database\Migrations\Migration;
use App\Database\Database;

class UserMigration extends Migration {
  public function migrate() {
    $sql = "
      CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username varchar(255) NOT NULL UNIQUE,
        email varchar(255) NOT NULL UNIQUE,
        password varchar(255) NOT NULL,
        role INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    ";

    $this->db->execute($sql);
  }
}
