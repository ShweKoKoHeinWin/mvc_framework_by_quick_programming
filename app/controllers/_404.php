<?php

namespace Controllers;

defined('ROOTPATH') or exit("Access Denied.");

class _404
{
    use \Core\Controller;
    public function index($name)
    {
        $this->view('404');
    }
}
