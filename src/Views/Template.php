<?php

namespace App\Views;

use App\Routes\Redirect;

class Template {
    private $path = __DIR__ . "/pages/";
    private $data = [];
    
    /**
     * Adds data to display inside the view
     * 
     * @param string $key Variable to display
     * @param mixed $value Variable value
     * 
     * Example usage:
     * $posts = $this->db->selectModel("posts");
     * $this->template->with("posts", $posts)->render("posts");
     */
    public function with($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Renders desired template inside pages/ directory
     * 
     * Example usage:
     * $this->template->render("posts");
     * 
     * @param string $view Template name
     */
    public function render($view) {
        $this->setPath($view);

        if($temp = Redirect::getFlashData()) {
            foreach($temp as $key=>$value) {
                $this->with($key, $value);
            }
        }

        extract($this->data);

        require_once $this->path;
    }

    private function setPath($view) {
        $this->path .= $view . ".php";
    }
}