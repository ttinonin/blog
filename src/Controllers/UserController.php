<?php

namespace App\Controllers;

use Exception;

use App\Models\User;
use App\Controllers\Controller;
use App\Routes\Redirect;

class UserController extends Controller {
  public function home() {
    $this->template->render('home');
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
      // $this->template->with('error', $e->getMessage())->render("create_user");
      Redirect::redirect('/', ['error' => $e->getMessage()]);      
    }

    $this->db->insertModel($user);
  }

  public function create_form() {
    $this->template->render("create_user");
  }
}
