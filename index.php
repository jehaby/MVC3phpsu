<?php

error_reporting(0);
define('APPLICATION_PATH', realpath(dirname(__FILE__)));
define('VIEWS_PATH', realpath(dirname(__FILE__)).'/Web/Views/');
set_include_path(
    APPLICATION_PATH . '/Lib' . PATH_SEPARATOR .
    APPLICATION_PATH . '/Web' . PATH_SEPARATOR .
    APPLICATION_PATH . '/Core' . PATH_SEPARATOR .
    './bbcode/' .PATH_SEPARATOR. get_include_path());


var_dump($_SERVER);

function __autoload($className)
{
    $fname = str_replace('_', '/', $className) . '.php';
    $result = include_once($fname);
    return $result;
}

$router = new Router();
$router->run();