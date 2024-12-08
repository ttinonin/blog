<?php

namespace Utils;

class Flags {
    private $flags = [];
  
    public function help() {
        echo <<<EOL
        PHP Utils v1.0.0
        
        Description:
          CLI to build files, manage migrations and run the development server.
        
        Build:
          build:middleware <class_name>  Create a middleware file with the given class name
          build:model <class_name>       Create a model file with the given class name
          build:controller <class_name>  Create a controller file with the given class name
          build:migration <class_name>   Create a migration file with the given class name
        
        Migrate:
          migrate:run              Execute all migrations inside the MigrationsManager
          migrate:drop             Drop all tables inside the MigrationsManager
        
        Server:
          start                    Start the development server on localhost
        
        Examples:
          php utils.php start --port=8080
          php utils.php build:middleware AuthMiddleware
          php utils.php migrate:run
        
        EOL;

      exit();
    }

    public function add($flag) {
      $argument = explode("=", $flag)[1];
      $key = str_replace("-", "", explode("=", $flag)[0]);
  
      $this->flags[$key] = $argument;
    }
  
    public function get($key) {
      if(isset($this->flags[$key])) {
        return $this->flags[$key];
      }
      
      return null;
    }
}