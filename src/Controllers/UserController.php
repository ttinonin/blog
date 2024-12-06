<?php

namespace App\Controllers;

use Exception;

use App\Models\User;
use App\Controllers\Controller;
use App\Routes\Redirect;
use App\Routes\Request;
use App\Services\Auth;

class UserController extends Controller {
  public function home() {
    $this->template->render('home');
  }

  public function create() {
    $username = Request::post("username");
    $password = Request::post("password");
    $email = Request::post("email");
    $password_confirm = Request::post("password_confirm");

    if($password !== $password_confirm) {
      Redirect::redirect('/create-user', ['error' => "Password and confirmation password must be the same."]);      
    }

    try {
      $user = new User(
        null,
        $username,
        $email,
        $password
      );
    } catch(Exception $e) {
      Redirect::redirect('/create-user', ['error' => $e->getMessage()]);      
    }
    
    $this->db->insertModel($user);

    if(!Auth::login($email, $password, $this->db)) {
      Redirect::redirect("/sign-in", ["error" => "Invalid email or password."]);
    }

    Redirect::redirect("/", ["success" => "Account created successfully"]);
  }

  public function create_form() {
    $this->template->render("create_user");
  }

  public function read() {
    $user_id = Request::get('id');

    $user = $this->db->selectSingleModel("user", [], ["id" => $user_id]);

    $this->template->with("user", $user)->render("single-user");
  }

  public function sign_in_form() {
    $this->template->render("sign-in");
  }

  public function sign_in() {
    $email = Request::post("email");
    $password = Request::post("password");

    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) <= 3) {
      Redirect::redirect("/sign-in", ["error" => "Invalid email or password."]);
    }

    if(!Auth::login($email, $password, $this->db)) {
      Redirect::redirect("/sign-in", ["error" => "Invalid email or password."]);
    }

    Redirect::redirect("/", ["success" => "Logged in successfully"]);
  }

  public function logout() {
    Auth::logout();

    Redirect::redirect("/", ["success" => "Logged out successfully"]);
  }
}
