<?php
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
