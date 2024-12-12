<?php

namespace Compiler\Utils;

class File {
    private $path;

    public function __construct($path) {
        $this->path = $path;
    }

    public function get_path() {
        return $this->path;
    }

    public function get_name() {
        $dir = explode("/", $this->path);

        return end($dir);
    }

    public function load() {
        $file = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) or die("Template not found.\n");

        $file = array_map('trim', $file);

        $data = implode('', $file);

        return $data;
    }

    public function write($file_name, $content) {
        $file = fopen($file_name, "w");

        fwrite($file, $content);

        fclose($file);
    }
}