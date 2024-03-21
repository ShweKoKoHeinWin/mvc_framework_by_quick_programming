<?php

namespace Controllers;

defined('ROOTPATH') or exit("Access Denied.");
class Home
{
    use \Core\Controller;
    public function index()
    {
        if (empty($_SESSION['USER'])) {
            $data['username'] = 'User';
        } else if (!empty($_SESSION['USER']->name)) {
            $data['username'] = $_SESSION['USER']->name;
        } else {
            $data['username'] = $_SESSION['USER']['name'];
        }

        $this->view('home', $data);
    }
}
