<?php

namespace Utils\Builders;

use Utils\Builders\Builder;

class ModelBuilder implements Builder {
    public static function build($file_name) {
      $path = __DIR__ . "/../../src/Models/" . $file_name . ".php";
      $file = fopen($path, "w") or die("\033[31m Error creating the file \033[0m\n");
      $content = <<<PHP
      <?php
  
      namespace App\Models;
  
      use App\Models\Model;
  
      class $file_name extends Model {
          
      }
      PHP;
  
      fwrite($file, $content);
      fclose($file);
  
      echo "\033[32m" . $file_name . " created with success at: " . $path . "\033[0m\n";
    }
}