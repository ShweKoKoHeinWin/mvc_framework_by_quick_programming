<?php

namespace Controllers;

use Model\User;

defined('ROOTPATH') or exit("Access Denied.");
class Logout
{
  use \Core\Controller;
  public function index()
  {
    $ses = new \Core\Session;
    $ses->logout();
    redirect('login');
  }
}
