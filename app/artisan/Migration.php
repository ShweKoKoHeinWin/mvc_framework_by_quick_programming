<?php

namespace Artisan;

defined('CPATH') or exit('Accessed Denied.');

trait Migration
{
  use \Core\Model;

  protected $columns = [];
  protected $keys = [];
  protected $primaryKeys = [];
  protected $uniqueKeys = [];
  protected $data = [];

  protected function addColumn($col_name)
  {
    $this->columns[] = $col_name;
  }

  protected function addPrimaryKey($col_name)
  {
    $this->primaryKeys[] = $col_name;
  }

  protected function addUniqueKeys($col_name)
  {
    $this->uniqueKeys[] = $col_name;
  }

  protected function addData($col_name, $value)
  {
    $this->data[$col_name] = $value;
  }

  protected function createTable($name)
  {
    if (!empty($this->columns)) {
      $query = "CREATE TABLE IF NOT EXISTS " . $name . " (";

      foreach ($this->columns as $column) {
        $query .= $column . ", ";
      }

      foreach ($this->primaryKeys as $key) {
        $query .= " PRIMARY KEY (`{$key}`), ";
      }

      foreach ($this->uniqueKeys as $key) {
        $query .= " UNIQUE KEY (`{$key}`), ";
      }

      foreach ($this->keys as $key) {
        $query .= " KEY (`{$key}`), ";
      }
      $query = trim($query, ', ');
      $query .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

      $this->query($query);

      $this->columns = [];
      $this->primaryKeys = [];
      $this->uniqueKeys = [];
      $this->keys = [];
      echo "\n\r {$name} Table is created successfully. \n\r";
    } else {
      echo "\n\r Columns are need to create $name table. \n\r";
    }
  }

  protected function dropTable($name)
  {
    $this->query("DROP TABLE IF EXISTS " . $name);
    echo "\n\r {$name} Table is dropped successfully. \n\r";
  }

  protected function insertData($table)
  {
    if (!empty($this->data)) {
      $keys = array_keys($this->data);
      $query = "INSERT INTO `{$table}` (" . implode(', ', $keys) . ") VALUES (:" . implode(', :', $keys) . ")";

      $this->query($query, $this->data);
      echo "\n\r Data inserted successfully to {$table} table. \n\r";
    } else {
      echo "\n\r No Data to insert into {$table} table. \n\r";
    }
  }
}
// CREATE TABLE `users` (
//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//   `name` varchar(25) NOT NULL,
//   `email` varchar(50) NOT NULL,
//   `password` varchar(100) NOT NULL,
//   `image` varchar(225) DEFAULT NULL,
//   `remark` text DEFAULT NULL,
//   `created_at` datetime DEFAULT current_timestamp(),
//   `deleted_at` datetime DEFAULT NULL,
//   `additional_info` text DEFAULT NULL,
//   PRIMARY KEY (`id`),
//   KEY `name` (`name`),
//   KEY `email` (`email`)
//  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci