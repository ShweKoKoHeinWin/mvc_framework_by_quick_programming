<?php

session_start();

require '../app/core/init.php';


$app = new App;
$app->loadController();
$users = new Model;
show($users->delete(['name' => 'Ko', 'age' => 99]));
// show($users->create(['name' => 'Ko']));
// show($users->create(['name' => 'Ko', 'age' => 66]));

// show($users->create(['name' => 'Shwe']));
// show($users->create(['age' => 99]));
