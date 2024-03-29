<?php

namespace Controllers;

use Model\User;
use \Core\Request;

defined('ROOTPATH') or exit("Access Denied.");
class Signup
{
  use \Core\Controller;
  public function index()
  {
    $request = new Request;
    $data = [];
    $data['user'] = new User;
    if ($request->posted()) {
      $data['user']->signup($_POST);
    }
    $this->view('signup', $data);
  }
}
