<?php

session_start();

require '../app/core/init.php';


$app = new App;
$app->loadController();
$users = new Model;
show($users->delete(['id' => 2, 'name' => 'shwe']));
