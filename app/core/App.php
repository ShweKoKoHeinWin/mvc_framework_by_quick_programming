<?php

class App
{
    private $controller = 'Home';
    private $method = 'index';

    private function splitURl()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode('/', $URL);
        return $URL;
    }

    public function loadController()
    {
        $URL = $this->splitURl();
        $filename = "../app/controllers/" . ucfirst($URL[0]) . '.php';
        $error404 = "../app/controllers/_404.php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
        } else {
            // echo "controller not found";
            require $error404;
            $this->controller = '_404';
        }

        $controller = new $this->controller;
        call_user_func_array([$controller, 'index'], ['name' => 'page']);
    }
}
