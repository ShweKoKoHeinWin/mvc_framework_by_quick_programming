<?php

namespace Controllers;

use Core\Request;
use Model\User;

defined('ROOTPATH') or exit("Access Denied.");
class Login
{
  use \Core\Controller;
  public function index()
  {
    $request = new Request;
    $data = [];
    $data['user'] = new User;
    if ($request->posted()) {
      $data['user']->login($_POST);
    }
    $this->view('signup', $data);
  }
}
