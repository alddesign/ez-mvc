<?php
//Set Error reporting as soon as possible
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

//Check for autoloder
if(!file_exists(__DIR__.'/vendor/autoload.php'))
{
    http_response_code(500);
    echo 'vendor/autoloader.php not found. Forgot "composer update"?';
    die;
}

//session_set_cookie_params(['samesite' => 'lax']);
session_start();

//Autoloader and config
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/config.php';

//Set Error reporting and timezone
ini_set('error_reporting', EZ_PHP_ERROR_REPORTING);
ini_set('display_errors', EZ_PHP_DISPLAY_ERRORS);
ini_set('display_startup_errors', EZ_PHP_DISPLAY_STARTUP_ERRORS);
date_default_timezone_set(EZ_DEFAULT_TIMEZONE);

//Load config
Alddesign\EzMvc\System\Config::load();

//Route request to controller action
Alddesign\EzMvc\System\Router::routeRequest();