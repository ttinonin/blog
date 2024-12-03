<?php

namespace App\Controllers;

use App\Views\Template;
use App\Database\Database;

/**
 * Controller is a base class
 * 
 * Every controller must extends the Controller class, to use basic functions, like database and templates manipulation
 * 
 * Example usage:
 * class UserController extends Controller {}
 */
class Controller {
    protected $db;
    protected $template;

    /**
     * Instantiates database and template classes.
     * 
     * Child classes can't have a contructor only the Controller class
     */
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