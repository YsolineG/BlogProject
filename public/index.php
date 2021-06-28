<?php

require '../config/dev.php';
require '../vendor/autoload.php';

session_start();
$router = new \BlogProject\config\Router();
$router->run();