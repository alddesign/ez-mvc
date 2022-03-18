<?php
$autoloader = __DIR__.'/vendor/autoload.php';
if(!file_exists($autoloader))
{
    die('Damn, run <b>composer update</b> before using EZ-MVC.<br/>Please, <a href="https://getcomposer.org">get composer.</a> and thank me later.');
}
require ($autoloader); //using composers autoloader file

session_start();

//Set default timezone as soon as possible
date_default_timezone_set(Alddesign\EzMvc\System\Config::system('default-timezone', 'UTC'));

//Route request to controller action
Alddesign\EzMvc\System\Router::routeRequest();