<?php

use twerkerapp\auth\TweeterAuthentication;

session_start();

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

/*
 * Router
 * */
$router = new \bfforever\router\Router();
$router->addRoute('home', '/home/', 'TweeterController', 'viewHome', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('tweet', '/tweet/', 'TweeterController', 'viewTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('user', '/user/', 'TweeterController', 'viewUserTweets', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('login', '/login/', 'TweeterController', 'phpInfo', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('signup', '/signup/', 'TweeterController', 'phpInfo', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('post', '/post/', 'TweeterController', 'viewPostTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('send', '/send/', 'TweeterController', 'sendTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->setDefaultRoute('/home/');

$router->run();