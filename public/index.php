<?php

require '../config/dev.php';
require '../vendor/autoload.php';

$router = new \BlogProject\config\Router();
$router->run();