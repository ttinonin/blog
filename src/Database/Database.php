<?php

namespace App\Database;

use PDO;
use App\Models\Model;
use Exception;

/**
 * The Database class is already instantiated in the Controller constructors. Do not instantiate this class manually.
 */
class Database {
  public $connection;

  /**
   * Connect to the database
   */
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
   * Runs a raw query
   * 
   * Example usage:
   * $this->db->raw("SELECT * FROM users WHERE id = :id", [":id" => 3]);
   * 
   * @param string $query_str Raw query
   * @param string[] $where Associative array with where param and condition
   * @return array
   */
  public function raw($query_str, $where = []) {
    $query = $this->connection->prepare($query_str);
    
    if(!empty($where)) {
      foreach($where as $condition=>$value) {
        $param_type = $this->getPDOType($value);
        $query->bindValue($condition, $value, $param_type);
      }
    }

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Runs a select query based on a model name
   * 
   * Example usage:
   * $this->db->selectModel("user", [], ["id" => 3]);
   * 
   * @param string $model Model name
   * @param string[]|null $params Columns names to select
   * @param string[]|null $where Associative array with where param and condition
   * @return array
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
      $query_str .= " ORDER BY created_at DESC ";

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

    $query_str .= " ORDER BY created_at DESC ";

    $query = $this->connection->prepare($query_str);
    $iteration = 0;
    foreach($where as $condition=>$value) {
      $param_type = $this->getPDOType($value);
      $query->bindValue(":" . $condition, $value, $param_type);
    }

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Runs a delete query based on a condition
   * 
   * Example usage:
   * $this->db->delete("user", ["id" => 3]);
   * 
   * @param string $model Model name
   * @param string[] $condition Associative array with where param and condition
   * @return void
   */
  public function delete($model, $condition) {
    if(empty($condition)) {
      throw new Exception("Can't delete without WHERE condition");
    }

    $condition_size = count($condition);
    $iteration = 0;
    
    $table = strtolower($model . 's');

    $query_str = "DELETE FROM " . $table . " WHERE ";
    foreach($condition as $key=>$value) {
      $iteration++;

      if($condition_size === $iteration) {
        $query_str .= $key . " = :" . $key;
        continue;
      }

      $query_str .= $key . " = :" . $key . " AND ";
    }

    $query = $this->connection->prepare($query_str);
    $iteration = 0;
    foreach($condition as $key=>$value) {
      $param_type = $this->getPDOType($value);
      $query->bindValue(":" . $key, $value, $param_type);
    }

    $query->execute();
    $query->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Runs a select query based on a model name, returning only one ocurrency
   * 
   * Example usage:
   * $this->db->selectModel("user", [], ["id" => 3]);
   * 
   * @param string $model Model name
   * @param string[]|null $params Columns names to select
   * @param string[]|null $where Associative array with where param and condition
   * @return array
   */
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
   * Insert a model into the database
   * 
   * Example usage:
   * $this->db->insertModel($user);
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
