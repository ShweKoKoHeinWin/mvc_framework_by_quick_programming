<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    // Database Config
    define('DB_NAME', 'quick_programming_mvc');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_DRIVER', '');

    // Absolute Dir
    define('ROOT', 'http://localhost/quick_programming/MVC/public/');
} else {

    // Database Config
    define('DB_NAME', 'quick_programming_mvc');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_DRIVER', '');

    // Absolute Dir
    define('ROOT', 'http://localhost/quick_programming/MVC/public/');
}


// define('APP_NAME', 'Quick Programming MVC');
define('DEBUG', true);
