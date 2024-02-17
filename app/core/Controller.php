<?php

trait Controller
{
    public function view($name)
    {
        $filename = "../app/views/" . $name . '.view.php';
        $error404 = "../app/views/404.php";
        if (file_exists($filename)) {
            require $filename;
        } else {
            // echo "controller not found";
            require $error404;
        }
    }
}
