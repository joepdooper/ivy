<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class Model {

  protected $table;
  protected $query;
  protected $bindings = [];
  protected $path;
  public $data = [];

  public function __construct()
  {
    $this->query = "SELECT * FROM `{$this->table}`";
  }

  // -- where
  public function where($column, $value)
  {

    if (is_null($value)) {
        if (strpos($this->query, 'WHERE') === false) {
            $this->query .= " WHERE `{$this->table}`.`{$column}` IS NULL";
        } else {
            $this->query .= " AND `{$this->table}`.`{$column}` IS NULL";
        }
    } else {
        if (strpos($this->query, 'WHERE') === false) {
            $this->query .= " WHERE `{$this->table}`.`{$column}` = :{$column}";
        } else {
            $this->query .= " AND `{$this->table}`.`{$column}` = :{$column}";
        }
        $this->bindings[$column] = $value;
    }

    return $this;
  }

  // -- join
  public function join($table, $firstColumn, $operator, $secondColumn)
  {
    $this->query .= " INNER JOIN $table ON `{$this->table}`.`{$firstColumn}` $operator `{$table}`.`{$secondColumn}`";

    return $this;
  }

  // -- order by
  public function orderBy($column, $direction = 'asc')
  {
    $this->query .= " ORDER BY `{$this->table}`.`{$column}` {$direction}";

    return $this;
  }

  // -- get
  public function get()
  {
    global $db;

    if (!empty($this->bindings)) {
      $data = $db->select($this->query, $this->bindings);
    } else {
      $data = $db->select($this->query);
    }

    if ($data) {
      foreach ($data as $key => $value) {
        $this->data[$key] = is_array($value) ? (object) $value : $value;
      }
    }

    return $this;
  }

  // -- set key by value of column name
  public function setKeyBy($columnname)
  {
    foreach ($this->data as $objectKey => $object) {
      foreach ($object as $key => $value) {
        if($key == $columnname) {
          unset($this->data[$objectKey]);
          $this->data[str_replace(' ', '_', strtolower($value))] = $object;
        }
      }
    }

    return $this;
  }

  // -- get row
  public function getRow()
  {
    global $db;

    if (!empty($this->bindings)) {
      $data = $db->selectRow($this->query, $this->bindings);
    } else {
      $data = $db->selectRow($this->query);
    }

    $this->data = (object) $data;

    return $this;
  }

  // -- return only the database data
  public function data()
  {
    return $this->data;
  }

  // -- insert
  public function insert($set)
  {
    global $db;

    $db->insert(
      $this->table,
      $set
    );

    return $db->getLastInsertId();
  }

  // -- update
  public function update($set)
  {
    global $db;

    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);

    $db->update(
      $this->table,
      $set,
      $this->bindings
    );

    return $db->getLastInsertId();
  }

  // -- delete
  public function delete()
  {
    global $db;

    $db->delete(
      $this->table,
      $this->bindings
    );

    return $db->getLastInsertId();
  }

  // -- save
  public function save($array)
  {
    // print_r($array);die;
    if(isset($array["delete"])){
      $this->bindings = ["id" => $array["id"]];
      $lastInsertId = $this->delete();
    }
    elseif(isset($array["id"])){
      $this->bindings = ["id" => $array["id"]];
      $lastInsertId = $this->update($array);
    }
    else {
      $key = key($array);
      if(!empty($array[$key])) {
        $lastInsertId = $this->insert($array);
      }
    }

    return $lastInsertId;
  }

  // -- post
  public function post() {
    global $auth;
    if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){
      try {
        foreach($_POST as $key => $array){
          if($key == $this->table) {
            foreach($array as $row){
              $this->save($row);
            }
          }
        }
        Message::add('Update succesfully', $this->path);
      } catch (Exception $e) {
        Message::add('Something went wrong', $this->path);
      }
    }
  }

}
?>
