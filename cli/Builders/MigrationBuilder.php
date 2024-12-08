<?php

namespace Utils\Builders;

use Utils\Builders\Builder;

class MigrationBuilder implements Builder {
    public static function build($file_name) {
        $path = __DIR__ . "/../../src/Database/Migrations/" . $file_name . ".php";
        $file = fopen($path, "w") or die("\033[31m Error creating the file \033[0m\n");
        $content = <<<PHP
        <?php

        namespace App\Database\Migrations;

        use App\Database\Migrations\Migration;

        class $file_name extends Migration {
            public function migrate() {
                \$sql = "";

                \$this->db->execute(\$sql);
            }
        }
        PHP;
    
        fwrite($file, $content);
        fclose($file);

        echo "\033[33mWarning: Don't forget to add the Migration to the MigrationsManager class\033[0m\n";
        echo "\033[32m" . $file_name . " created with success at: " . $path . "\033[0m\n";
    }
}