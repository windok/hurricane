<?php
define('PROJECT_PATH', __DIR__ . '/../');

use Hurricane\Hurricane;
use Hurricane\Router\Router;
use Hurricane\ServiceLocator\ServiceLocator;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

date_default_timezone_set('UTC');

require_once PROJECT_PATH . 'vendor/autoload.php';

$router = (new Router())->removeExtraSlashes();
require_once PROJECT_PATH . 'config/routes.php';

$serviceLocator = new ServiceLocator();
$serviceLocator->setShared('router', $router);
require_once PROJECT_PATH . 'config/services.php';


// todo register error handlers

(new Hurricane($serviceLocator))->handle();