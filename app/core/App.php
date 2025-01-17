<?php

namespace Core;

defined('ROOTPATH') or exit("Access Denied.");

class App
{
    private $controller = ' \Controllers\Home';
    private $method = 'index';

    private function splitURl()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode('/', trim($URL, '/'));
        return $URL;
    }

    public function loadController()
    {
        $URL = $this->splitURl();
        show(ucfirst($URL[0]));
        $filename = "../app/controllers/" . ucfirst($URL[0]) . '.php';
        $error404 = "../app/controllers/_404.php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = $this->controller = "\\Controllers\\" .  ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // echo "controller not found";
            require $error404;
            $this->controller = "\\Controllers\\" . '_404';
        }

        $controller = new $this->controller;
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
        call_user_func_array([$controller, $this->method], $URL);
    }
}
