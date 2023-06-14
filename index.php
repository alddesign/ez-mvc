<?php
//Set Error defaults to catch early configuration errors:
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
ini_set('error_reporting', -1);

//Check for autoloder and embed it
if(!file_exists(__DIR__.'/vendor/autoload.php'))
{
    http_response_code(500);
    echo 'vendor/autoloader.php not found. Forgot "composer update"?';
    die;
}
require(__DIR__.'/vendor/autoload.php');

session_start();

//Loads the config
Alddesign\EzMvc\System\Config::load();

//Set Error reporting as configured
ini_set('display_errors', Alddesign\EzMvc\System\Config::system('php-display-errors', 'On'));
ini_set('display_startup_errors', Alddesign\EzMvc\System\Config::system('php-display-startup-errors', 'On'));
ini_set('error_reporting', Alddesign\EzMvc\System\Config::system('php-error-reporting', E_ALL));

//Set default timezone as soon as possible
date_default_timezone_set(Alddesign\EzMvc\System\Config::system('default-timezone', 'UTC'));

//Route request to controller action
Alddesign\EzMvc\System\Router::routeRequest();