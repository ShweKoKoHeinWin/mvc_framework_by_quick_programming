<?php

namespace Artisan;


defined('CPATH') or exit('Accessed Denied.');

class Artisan
{
  public $version = '1.0.0';
  public function serve($mode, $option = "--port=8000") {
    $port = 8000;
    if (preg_match('/^--[a-z]+/', $option)) {
      $parts = explode('=', $option);

      if (!empty($parts)) {
        $type = $parts[0];
        $port = $parts[1] ? $parts[1] : 8000;
      }
    }
    echo "Running Project at the port $port \n";
    exec("php -S localhost:$port -t public");
    
  }

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
        [
          $class_name, $directory, $file_name, $namespace_parts
        ] = $this->getFileInfo($class_name, 'migration');

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

        $sample_file = file_get_contents('app' . DS . 'artisan' . DS . 'samples' . DS . 'migration.php');
        $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($class_name), $sample_file);
        // $sample_file = preg_replace('/\{TABLENAME\}/', $table_name, $sample_file);

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
        $d = new \Artisan\Migration;
        $d->dropTable('users');
        die($mode);
        break;

      case 'db:drop':

        break;

      case 'db:table':

        break;
    }
  }

  public function migrate($mode, $option = "")
  {
    echo $option;
    $single_file = '';
    $directory = "app" . DS . "migration" . DS;
    $pattern = '/([a-zA-Z_]+)\.php$/';
    if (!empty($option)) {
      if (preg_match('/^--[a-z]+/', $option)) {
        if (preg_match('/^--file=+/', $option)) {
          $parts = explode('=', $option);
          $single_file = $parts[1];
        }
      } else {
        die('INvalid Options');
      }

      switch ($mode) {
        case 'migrate':
          $file_full_name = $directory . $single_file;
          if (file_exists($file_full_name)) {
            if (preg_match($pattern, $single_file, $matches)) {
              require_once $file_full_name;
              $class = ucfirst(trim($matches[1], '_'));
              $migration = new ("\\Migration\\" . $class);
              $migration->up();
            } else {
              echo 'No match found.';
            }
          } else {
            die('File Not found.');
          }

          break;

        case 'migrate:rollback':
          $file_full_name = $directory . $single_file;
          if (file_exists($file_full_name)) {
            if (preg_match($pattern, $single_file, $matches)) {
              require_once $file_full_name;
              $class = ucfirst(trim($matches[1], '_'));
              $migration = new ("\\Migration\\" . $class);
              $migration->down();
            } else {
              echo 'No match found.';
            }
          } else {
            die('File Not found.');
          }
          break;

        default;
          die('No Migrate Method exist.');
      }
    } else {
      $files = $this->getMigrationFiles() ?? [];

      switch ($mode) {
        case 'migrate':

          foreach ($files as $file) {
            $file_path = basename($file);

            $this->migrate("migrate", "--file=$file_path");
          }
          break;

        case 'migrate:refresh':
          foreach ($files as $file) {
            $file_path = basename($file);
            $this->migrate("migrate:rollback", "--file=$file_path");
            $this->migrate("migrate", "--file=$file_path");
          }
          break;

        case 'migrate:list':

          echo "Migrations : \n\r";
          foreach ($files as $file) {
            $file_path = basename($file);
            echo "$file_path \n";
          }
          break;
      }
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
    $file_name = "app" . DS . $type . DS;
    $directory = "app" . DS . $type . DS;
    $namespace_parts = [];
    if ($type == "migration") {
      $date_part = date("jS_M_Y_H_i_s_");
      if (strpos($class_name, '\\') !== false || strpos($class_name, '/') !== false) {
        die('Name is invalid');
      } else {
        $file_name = $file_name . $date_part . $class_name . '.php';
      }
    } else {
      // Check $name has namespaces
      if (strpos($class_name, '\\') !== false) {
        $parts = explode('\\', $class_name);

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
    }

    return [
      $class_name,
      $directory,
      $file_name,
      $namespace_parts
    ];
  }

  private function getMigrationFiles()
  {
    $folder = "app" . DS . 'migration' . DS;
    if (!file_exists($folder)) {
      die("No migration files are found.");
    }

    $files = glob($folder . "*.php");
    if (empty($files)) {
      die('No migrations files.');
      return [];
    }

    return $files;
  }
}
