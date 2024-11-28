<?php

namespace App\Models;

use Exception;

class User {
  private $id;
  private $username;
  private $email;
  private $password;

  public function __construct($id, $username, $email, $password) {
    $this->id = $id;
    $this->setUsername($username);
    $this->setEmail($email);
    $this->setPassword($password);
  }

  public function setUsername($username) {
    if(strlen($username) <= 0 || strlen($username) > 255) {
      throw new Exception("Invalid username.");
    }

    $this->username = $username;
  }

  public function setEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Invalid email.");
    }

    $this->email = $email;
  }

  public function setPassword($password) {
    if(strlen($password) <= 3) {
      throw new Exception("Password must be at least 4 characters long.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $this->password = $hashed_password;
  }
}
