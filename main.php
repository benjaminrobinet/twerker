<?php

use Illuminate\Database\Capsule\Manager as DB;
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

DB::connection()->enableQueryLog();

/*
 * Router
 * */
$router = new \bfforever\router\Router();
$router->addRoute('home', '/home/', 'TweeterController', 'viewHome', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('tweet', '/tweet/', 'TweeterController', 'viewTweet', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('like', '/like/', 'TweeterController', 'likeTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('dislike', '/dislike/', 'TweeterController', 'dislikeTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('user', '/user/', 'TweeterController', 'viewUserTweets', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('login', '/login/', 'TweeterAdminController', 'viewLogin', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('logout', '/logout/', 'TweeterAdminController', 'makeLogout', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('login_check', '/login_check/', 'TweeterAdminController', 'checkLogin', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('signup', '/signup/', 'TweeterAdminController', 'viewSignup', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('signup_check', '/signup_check/', 'TweeterAdminController', 'checkSignup', TweeterAuthentication::ACCESS_LEVEL_NONE);
$router->addRoute('me', '/me/', 'TweeterController', 'viewMe', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('post', '/post/', 'TweeterController', 'viewPostTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('send', '/send/', 'TweeterController', 'sendTweet', TweeterAuthentication::ACCESS_LEVEL_USER);
$router->addRoute('dashboard', '/dashboard/', 'DashboardController', 'viewUsersByFollowers', TweeterAuthentication::ACCESS_LEVEL_PARTNER);
$router->setDefaultRoute('/home/');

$router->run();

$queries = DB::getQueryLog();