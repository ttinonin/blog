<?php

namespace App\Models;

use Exception;

use App\Models\Model;

class Post extends Model {
    private $id;
    private $title;
    private $body;
    private $user_id;

    public function __construct($id = null, $title, $body, $user_id) {
        $this->id = $id;
        $this->setTitle($title);
        $this->setBody($body);
        $this->setUserId($user_id);
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setBody($body) {
        if(strlen($body) <= 3) {
            throw new Exception("Invalid body.");
        }

        $this->body = $body;
    }

    public function setTitle($title) {
        if(strlen($title) <= 3) {
            throw new Exception("Invalid title.");
        }

        $this->title = $title;
    }
}