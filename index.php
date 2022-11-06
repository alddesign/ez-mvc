<?php
$autoloader = __DIR__.'/vendor/autoload.php';
if(!file_exists($autoloader))
{
    die('Damn, run <b>composer update</b> before using EZ-MVC.<br/>Please, <a href="https://getcomposer.org">get composer.</a> and thank me later.');
}
require ($autoloader); //using composers autoloader file

session_start();

//Loads the config
Alddesign\EzMvc\System\Config::load();

//Error reporting & display
ini_set('display_errors', Alddesign\EzMvc\System\Config::system('php-display-errors', 'On'));
ini_set('display_startup_errors', Alddesign\EzMvc\System\Config::system('php-display-startup-errors', 'On'));
ini_set('error_reporting', Alddesign\EzMvc\System\Config::system('php-error-reporting', E_ALL));

//Set default timezone as soon as possible
date_default_timezone_set(Alddesign\EzMvc\System\Config::system('default-timezone', 'UTC'));

//Route request to controller action
Alddesign\EzMvc\System\Router::routeRequest();