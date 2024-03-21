<?php

defined('ROOTPATH') or exit("Access Denied.");

spl_autoload_register(function ($className) {
    show($className);
    require "../app/models/" . ucfirst($className) . ".php";
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';
require 'Session.php';
require 'Request.php';
require 'Pager.php';
require 'Image.php';
