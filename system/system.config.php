<?php
/**
 * System config. Do not change keys, only values.
 * 
 * Database connection is done via PDO
 * @link https://www.php.net/manual/en/class.pdo.php
 */

//Make sure to return an array
return
[
    'app-name' => 'EZ MVC Sample App',          //The name of your app
    'base-url' => 'http://localhost/ez-mvc/',    //Them url pointing to the root directory of EZ-MVC (where the index.php is located)
    'default-controller' => 'Main',             //The default controller when none is specified
    'default-action' => 'index',                //The default action when none is specified
    'default-timezone' => 'Europe/Vienna',      //See: https://www.php.net/manual/de/timezones.php
    'db-driver' => 'sqlite',                    //'mysql', 'sqlite' and 'sqlsrv' are supported for now. https://www.php.net/manual/en/pdo.drivers.php 
    'db-name' => dirname(__DIR__) . '/app/sample-database.sqlite', //Name of the database of path to file in case of sqlite
    'db-host' => '',                            
    'db-port' => null,                          //null for default port 
    'db-user' => '',
    'db-password' => '',
    'db-options' => null,                       //Example: [PDO::ATTR_PERSISTENT => true]. https://www.php.net/manual/en/pdo.construct.php 
    'db-error-mode' => PDO::ERRMODE_EXCEPTION,  //Specify the way you like to deal with DB Errors. ERRMODE_EXCEPTION is recommended, as it is also the default in php8 See PDO::ATTR_ERRMODE on https://www.php.net/manual/en/pdo.setattribute.php
    'php-display-errors' => 'On',               //'On' | 'Off'. Specify if PHP shows runtime errors at all. See https://www.php.net/manual/en/errorfunc.configuration.php#ini.display-errors
    'php-display-startup-errors' => 'On',       //'On' | 'Off'. Specify if PHP startup errors. See: https://www.php.net/manual/en/errorfunc.configuration.php#ini.display-startup-errors
    'php-error-reporting' => -1,                //See: https://www.php.net/manual/en/function.error-reporting.php
    'version' => 'v1.0.0-beta.3'				//Version of ez-mvc (just in case u wanna know)
]; 