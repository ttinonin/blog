<?php

class Database {
  private static $connectRead;
  private static $connectWrite;

  public static function read() {
    if(self::$connectRead == null) {
      self::$connectRead = new PDO("mysql:host=localhost;dbname=blogdb;charset=utf8", "root", "");
      self::$connectRead->setAttribute();
      self::$connectRead->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$connectRead->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return self::$connectRead;
  }
}
