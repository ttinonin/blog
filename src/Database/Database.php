<?php

namespace App\Database;

use PDO;

class Database {
  public $connection;

  public function connect() {
    try {
      $this->connection = new PDO("mysql:host=localhost;dbname=blogdb;charset=utf8", "root", "root");
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      return $this->connection;
    } catch(\PDOException $e) {
      die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }  
  }

  /**
   *  Insert data into a table
   *
   *  @param string $table Table name
   *  @param string[] $params List of params from model
   *  @param mixed[] $values List of values from model
   *  @return void
   * */
  public function insert($table, $params, $values) {
    $query_string = "INSERT INTO " . $table . " (";

    $query = $this->connection->prepare("");
  }
}
