<?php

namespace App\Database;

use PDO;
use App\Models\Model;

class Database {
  public $connection;

  public function connect() {
    try {
      $this->connection = new PDO("mysql:host=localhost;dbname=blogdb;charset=utf8", "root", "root");
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      return $this->connection;
    } catch(\PDOException $e) {
      die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }  
  }

  public function execute($sql) {
    $this->connection->exec($sql);
  }

  /**
   *  Insert data into a table
   *
   *  @param string $table Table name
   *  @param string[] $params List of params from model
   *  @param mixed[] $values List of values from model
   *  @return void
   * */
  public function insertRaw($table, $params, $values) {
    $query_string = "INSERT INTO " . $table . " (";

    $query = $this->connection->prepare("");
  }

  /**
   * 
   */
  public function selectModel($model, $params = [], $where = []) {
    $table = strtolower($model . 's');
    $param_size = count($params);
    $where_size = count($where);
    $iteration = 0;

    $query_str = "SELECT ";

    if(empty($params)) {
      $query_str .= "* FROM " . $table . " ";
    } else {
      foreach($params as $param) {
        $iteration++;

        if($param_size === $iteration) {
          $query_str .= $param . " FROM " . $table . " ";
          continue;
        }

        $query_str .= $param . ", ";
      }
    }

    if(empty($where)) {
      $query = $this->connection->prepare($query_str);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $iteration = 0;
    $query_str .= "WHERE ";
    foreach($where as $condition=>$value) {
      $iteration++;
      
      if($where_size === $iteration) {
        $query_str .= $condition . " = :" . $condition . " ";
        continue;
      }

      $query_str .= $condition . " = :" . $condition . " AND "; 
    }

    $query = $this->connection->prepare($query_str);
    $iteration = 0;
    foreach($where as $condition=>$value) {
      $param_type = $this->getPDOType($value);
      $query->bindValue(":" . $condition, $value, $param_type);
    }

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectSingleModel($model, $params = [], $where = []) {
    $table = strtolower($model . 's');
    $param_size = count($params);
    $where_size = count($where);
    $iteration = 0;

    $query_str = "SELECT ";

    if(empty($params)) {
      $query_str .= "* FROM " . $table . " ";
    } else {
      foreach($params as $param) {
        $iteration++;

        if($param_size === $iteration) {
          $query_str .= $param . " FROM " . $table . " ";
          continue;
        }

        $query_str .= $param . ", ";
      }
    }

    if(empty($where)) {
      $query = $this->connection->prepare($query_str);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    }

    $iteration = 0;
    $query_str .= "WHERE ";
    foreach($where as $condition=>$value) {
      $iteration++;

      if($where_size === $iteration) {
        $query_str .= $condition . " = :" . $condition . " ";
        continue;
      }

      $query_str .= $condition . " = :" . $condition . " AND "; 
    }

    $query = $this->connection->prepare($query_str);
    $iteration = 0;
    foreach($where as $condition=>$value) {
      $param_type = $this->getPDOType($value);
      $query->bindValue(":" . $condition, $value, $param_type);
    }

    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Insert the model based on its name and params
   * 
   * @param Model $model Model reference
   * @return boolean
   */
  public function insertModel(Model $model) {
    $table = $model->getModelName();
    $params = $model->getModelParams();
    $param_size = count($params);
    $iteration = 0;

    $query_str = "INSERT INTO " . $table . " (";
    $param_str = "";
    $values_str = " VALUES (";
    foreach($params as $param=>$value) {
      $iteration++;

      if($param === "id") {
        continue;
      }

      if($param_size === $iteration) {
        $param_str .= $param . ")";
        $values_str .= ":" . $param . ")";
        continue;
      }
      
      $param_str .= $param . ", ";
      $values_str .= ":" . $param . ", ";
    }

    $query_str.= $param_str . " " . $values_str;

    $query = $this->connection->prepare($query_str);
    
    foreach ($params as $param => $value) {
      if ($param === "id") {
          continue;
      }

      $param_type = $this->getPDOType($value);
      $query->bindValue(":" . $param, $value, $param_type);
    }

    $query->execute();
    $rowCount = $query->rowCount();
  
    if($rowCount === 0) {
      return false;
    }

    return true;
  }

  private function getPDOType($value) {
    switch(gettype($value)) {
      case 'double':
      case 'integer':
        return PDO::PARAM_INT;
        break;
      case 'string':
        return PDO::PARAM_STR;
        break;
      default:
        return PDO::PARAM_STR;
        break;
    }
  }
}
