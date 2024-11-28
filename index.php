<?php

require __DIR__ . "/vendor/autoload.php";

use App\Database\Migrations\UserMigration;

$migration = new UserMigration();

$migration->migrate();
