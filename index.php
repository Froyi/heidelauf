<?php

namespace Project;

use Project\Controller\IndexController;
use Project\Utilities\Tools;

session_start();

define('ROOT_PATH', getcwd());
date_default_timezone_set('Europe/Berlin');

require ROOT_PATH . '/vendor/autoload.php';

$route = 'index';

if (Tools::getValue('route') !== false) {
    $route = Tools::getValue('route');
}

$configuration = new Configuration();

try {
    $routing = new Routing($configuration);
    $routing->startRoute($route);
} catch (\InvalidArgumentException $error) {
    $indexController = new IndexController($configuration, $route);
    try {
        $indexController->errorPageAction();
    } catch (\Twig_Error_Loader | \Twig_Error_Runtime | \Twig_Error_Syntax $e) {
        echo 'There is something wrong!';
        exit;
    }
}