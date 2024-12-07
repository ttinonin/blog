<?php

namespace Utils\Builders;

use Utils\Builders\Builder;

class MiddlewareBuilder extends Builder {
    public static function build($file_name) {
      $path = __DIR__ . "/../../src/Routes/Middlewares/" . $file_name . ".php";
      $file = fopen($path, "w") or die("\033[31m Error creating the file \033[0m\n");
      $content = <<<PHP
      <?php
  
      namespace App\Routes\Middlewares;
  
      use App\Routes\Middlewares\Middleware;
  
      class $file_name extends Middleware {
          public function handle() {              
              return true;
          }
      }
      PHP;
  
      fwrite($file, $content);
      fclose($file);
  
      echo "\033[32m" . $file_name . " created with success at: " . $path . "\033[0m\n";
    }
}