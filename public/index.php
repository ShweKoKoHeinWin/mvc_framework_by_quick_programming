<?php

session_start();

require '../app/core/init.php';

DEBUG ? ini_set('display_errors', 1) :  ini_set('display_errors', 0);

$app = new App;
$app->loadController();
// $users = new Model;
// show($users->delete(['name' => 'Ko', 'age' => 99]));
// show($users->create(['name' => 'Ko']));
// show($users->create(['name' => 'Ko', 'age' => 66]));

// show($users->create(['name' => 'Shwe']));
// show($users->create(['age' => 99]));
