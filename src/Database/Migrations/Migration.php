<?php

namespace App\Database\Migrations;

use App\Database\Database;

/**
 * Migrations base class
 *
 * Set base table functions (create | drop)
 *
  * */
class Migration {
  protected $db;

  public function __construct() {
    $this->db = new Database();
    $this->db->connect();
  }

  /**
   * Drop a table according to model name 
   * */
  public function drop() {
    $table = basename(str_replace('\\', '/',get_class($this)));
    $table = preg_replace('/Migration$/', '', $table) . 's';
    $table = strtolower($table);
    
    $sql = "DROP TABLE IF EXISTS " . $table;

    $this->db->connection->exec($sql);
  }

  /**
   * Must be overrrided with the CREATE TABLE script
    **/
  public function migrate() {}
}
