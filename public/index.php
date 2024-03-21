<?php

session_start();

$minPHPVersion = '8.0';
if (phpversion() < $minPHPVersion) {
    die("Your PHp Version must be {$minPHPVersion} or higher Version. Your Php Version is " . phpversion());
}

define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);

require '../app/core/init.php';

DEBUG ? ini_set('display_errors', 1) :  ini_set('display_errors', 0);

$app = new \Core\App;
$app->loadController();
// $users = new Model;
// show($users->delete(['name' => 'Ko', 'age' => 99]));
// show($users->create(['name' => 'Ko']));
// show($users->create(['name' => 'Ko', 'age' => 66]));

// show($users->create(['name' => 'Shwe']));
// show($users->create(['age' => 99]));
