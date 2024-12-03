<?php

namespace App\Controllers;

use App\Views\Template;
use App\Database\Database;

class Controller {
    protected $db;
    protected $template;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();

        $this->template = new Template();
    }

    /** Must be overrided for POST */
    public function create() {}

    /** Must be overrided for DELETE */
    public function delete() {}

    /** Must be overrided for GET */
    public function read() {}

    /** Must be overrided for PATCH (or PUT) */
    public function update() {}
}