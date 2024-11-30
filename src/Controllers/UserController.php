<?php

namespace App\Controllers;

use App\Database\Database;

class UserController {
  private $db;

  public function __construct() {
    $db = new Database();
    $db->connect();
  }

  public function create() {
    var_dump($_POST);
  }

  public function create_form() {
    echo "test";
  }
}
