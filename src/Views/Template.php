<?php

namespace App\Views;

use App\Routes\Redirect;

class Template {
    private $path = __DIR__ . "/pages/";
    private $data = [];
    
    public function with($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    public function render($view) {
        $this->setPath($view);

        extract($this->data);

        require_once $this->path;
    }

    private function setPath($view) {
        $this->path .= $view . ".php";
    }
}