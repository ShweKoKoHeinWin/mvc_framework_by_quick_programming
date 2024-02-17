<?php

trait Controller
{
    public function view($name, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }
        $filename = "../app/views/" . $name . '.view.php';
        $error404 = "../app/views/404.view.php";
        if (file_exists($filename)) {
            require $filename;
        } else {
            // echo "controller not found";
            require $error404;
        }
    }
}
