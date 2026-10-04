<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/website_HKSATUTUJUH');

session_start();

require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/config/users.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';

$router = new Router();
$router->run();