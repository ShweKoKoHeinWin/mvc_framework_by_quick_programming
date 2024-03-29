<?php

namespace Artisan;


defined('CPATH') or exit('Accessed Denied.');


class Artisan
{
  public $version = '1.0.0';
  public function make($mode, $class_name = "", $option = "")
  {

    if (empty($class_name)) {
      die('Class Name is empty');
    }
    if (!empty($option)) {
      if (preg_match('/^--[a-z]+/', $option)) {
        $parts = explode('=', $option);

        if (!empty($parts)) {
          $type = $parts[0];
          $name = $parts[1] ?? '';
          $option = [];
          $option['type'] = $type;
          $option['name'] = $name;
        } else {
          $option = [];
          $option['type'] = $option;
        }
      } else {
        $option = [];
        $option['type'] = $option;
      }
    } else {
      $option = [];
    }

    $table_name = '';
    switch ($mode) {

      case 'make:controller':

        [
          $class_name, $directory, $file_name, $namespace_parts
        ] = $this->getFileInfo($class_name, 'controllers');

        if (count($option) > 0 && $option['type'] == '--resource') {
          $resource = true;
        } else {
          $resource = false;
        }

        if (!preg_match('/^[a-zA-Z_]+/', $class_name)) {
          die('Class Name is invalid');
        }

        if (file_exists($file_name)) {
          die("Controller {$file_name} already Existed.");
        }
        if (count($namespace_parts) > 0) {
          $namespace = implode('\\', $namespace_parts) . "\Controllers";
        } else {
          $namespace = 'Controllers';
        }

        $sample_file = file_get_contents('app' . DS . 'artisan' . DS . 'samples' . DS . 'controller.php');


        $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($class_name), $sample_file);
        $sample_file = preg_replace('/\{NAMESPACE\}/', $namespace, $sample_file);
        if ($resource) {
          $resource_file = file_get_contents('app' . DS . 'artisan' . DS . 'samples' . DS . 'controller_resource.php');
          $sample_file = preg_replace('/\{RESOURCE\}/', $resource_file, $sample_file);
        } else {
          $sample_file = preg_replace('/\{RESOURCE\}/', '', $sample_file);
        }

        if ($directory && !file_exists($directory)) {
          mkdir($directory, 0777, true); // Adjust permissions as needed
        }

        if (file_put_contents($file_name, $sample_file)) {
          die("{$file_name} is successfully created.");
        } else {
          die('Something Went Wrong. Please Try Again.');
        }
        break;

      case 'make:model':

        [
          $class_name, $directory, $file_name, $namespace_parts
        ] = $this->getFileInfo($class_name, 'models');

        if (count($option) > 0 && $option['type'] == '--table') {
          $table_name = $option['name'];
        } else {
          $table_name = strtolower($class_name) . 's';
        }

        if (!preg_match('/^[a-zA-Z_]+/', $class_name)) {
          die('Class Name is invalid');
        }

        if (file_exists($file_name)) {
          die("Model {$file_name} already Existed.");
        }
        if (count($namespace_parts) > 0) {
          $namespace = implode('\\', $namespace_parts) . "\Models";
        } else {
          $namespace = 'Models';
        }

        $sample_file = file_get_contents('app' . DS . 'artisan' . DS . 'samples' . DS . 'model.php');
        $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($class_name), $sample_file);
        $sample_file = preg_replace('/\{NAMESPACE\}/', $namespace, $sample_file);
        $sample_file = preg_replace('/\{TABLENAME\}/', $table_name, $sample_file);

        if ($directory) {
          if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Adjust permissions as needed
          }
        }

        if (file_put_contents($file_name, $sample_file)) {
          die("{$file_name} is successfully created.");
        } else {
          die('Something Went Wrong. Please Try Again.');
        }

        break;

      case 'make:migration':

        break;


      default:
        die("Undefined Command");
        break;
    }
  }

  public function db($mode, $class_name = "", $option = "")
  {
    if (empty($class_name)) {
      die('Class Name is empty');
    }
    if (!empty($option)) {
      if (preg_match('/^--[a-z]+/', $option)) {
        $parts = explode('=', $option);

        if (!empty($parts)) {
          $type = $parts[0];
          $name = $parts[1] ?? '';
          $option = [];
          $option['type'] = $type;
          $option['name'] = $name;
        } else {
          $option = [];
          $option['type'] = $option;
        }
      } else {
        $option = [];
        $option['type'] = $option;
      }
    } else {
      $option = [];
    }

    switch ($mode) {
      case 'db:create':
        die($mode);
        break;

      case 'db:drop':

        break;

      case 'db:table':

        break;
    }
  }

  public function help()
  {
    echo "
      Custom Artisan Version({$this->version}) Command Line Tool 
        Generators 
          make:migration  
          make:controller
          make:seeder
          make:model 

        Database
          db:create
          db:seed
          db:table
          db:drop
          
          migrate
          migrate rollback
          migrate refresh 
    ";
  }

  private function getFileInfo($class_name, $type = "")
  {
    // Check $name has namespaces
    if (strpos($class_name, '\\') !== false) {
      $parts = explode('\\', $class_name);
      $file_name = "app" . DS . $type . DS;
      $directory = "app" . DS . $type . DS;
      $namespace_parts = [];
      foreach ($parts as $key => $part) {
        if ($key != count($parts) - 1) {
          $file_name .= $part . DS;
          $directory .= $part . DS;
          $namespace_parts[] = ucfirst($part);
        } else {
          $file_name .= ucfirst($part) . '.php';
          $class_name = ucfirst($part);
        }
      }
    } else {
      $directory = '';
      $namespace_parts = [];
      $file_name = 'app' . DS . $type . DS . ucfirst($class_name) . '.php';
    }

    return [
      $class_name,
      $directory,
      $file_name,
      $namespace_parts
    ];
  }
}
