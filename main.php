<?php
//header('Content-Type: application/json');

/**
 * Require composer autoload
 */
require_once 'vendor/autoload.php';

/**
 * Register bfforever autoload
 */
require_once 'src/bfforever/utils/ClassLoader.php';
$autoload = new bfforever\utils\ClassLoader('src');
$autoload->register();

/**
 * Eloquent instance
 */
$config = parse_ini_file("conf/configuration.ini", true); /* parse config file */

$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection($config['database']);
$db->setAsGlobal();
$db->bootEloquent();

$router = new \bfforever\router\Router();
$router->addRoute('home', '/home', 'TweeterController', 'viewHome');
$router->addRoute('tweet', '/tweet', 'TweeterController', 'viewTweet');
$router->setDefaultRoute('/home');

$router->run();

//$ctrl = new \twerkerapp\controller\TweeterController();
//echo $ctrl->viewHome();