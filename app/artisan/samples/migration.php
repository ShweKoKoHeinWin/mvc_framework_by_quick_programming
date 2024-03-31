<?php

namespace Migration;

use \Artisan\Migration;
defined('ROOTPATH') or exit("Access Denied.");
class {CLASSNAME}
{
  use Migration;
  protected $table = '';


  public function up() {

  }
  public function down() {
    $this->dropTable();
  }
}
