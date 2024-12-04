<?php

namespace App\Controllers;

use App\Controllers\Controller;

class PostController extends Controller {
    public function create_form() {
        $this->template->render('create-post');
    }
}