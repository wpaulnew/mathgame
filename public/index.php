<?php

session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/**
 * Define
 */

define('APP', dirname(__DIR__) . '/app');
define('VENDOR', dirname(__DIR__) . '/vendor');
define('VENDOR_CORE', dirname(__DIR__) . '/vendor/core');
define('CORE', '/core');
define('VIEWS', dirname(__DIR__) . '/app/views');
define('PUBLIC', dirname(__DIR__) . '/public');


/**
 * Autoload
 */
//require dirname(__DIR__) . '/public/autoloader.php';
//
//// задаем соответствие для неймспейса Model и регистрируем автозагрузчик
//$autoloader = new NamespaceAutoloader();
//$autoloader->addNamespace('vendor\core', VENDOR_CORE . '/');
//$autoloader->addNamespace('app\models', APP . '/models');
//$autoloader->register();
//
//define("ROOT", dirname(__DIR__));

spl_autoload_register(function ($class) {

    $path = dirname(dirname(__FILE__)) . '/' . str_replace('\\', '/', $class);
//    var_dump($path);
    require($path . '.php');
    spl_autoload($path);
});

/**
 * Error and Exception handling
 */

/**
 * Run app
 */

//require_once(APP . '/core/Router.php');
$routes = require_once(VENDOR . '/settings/routes.php');
$router = new \vendor\core\Router($routes);
$router->run();
