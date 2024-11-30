<?php

namespace App\Controllers;

use Exception;
use App\Models\User;
use App\Views\Template;
use App\Database\Database;

class UserController {
  private $db;
  private $template;

  public function __construct() {
    $this->db = new Database();
    $this->db->connect();

    $this->template = new Template();
  }

  public function create() {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    try {
      $user = new User(
        null,
        $username,
        $email,
        $password
      );
    } catch(Exception $e) {
      $this->template->with('error', $e->getMessage())->render("create_user");
      return;
    }

    var_dump($user);
  }

  public function create_form() {
    $this->template->render("create_user");
  }
}
