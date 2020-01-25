<?php
/**
 * System config. Do not change keys, only values.
 * 
 * Database connection is done via PDO
 * @link https://www.php.net/manual/en/class.pdo.php
 */
$GLOBALS["_EZMVC_SYS_CONFIG"] =
[
    "app-name" => "Sample App",                 //The name of your app
    "base-url" => "http://localhost/ez-mvc",    //Them url pointing to the root directory of EZ-MVC (where the index.php is located)
    "default-controller" => "Main",             //The default controller when none is specified
    "default-action" => "index",                //The default action when none is specified
    "db-driver" => "sqlite",                    //"mysql", "sqlite" and "sqlsrv" are supported for now. https://www.php.net/manual/en/pdo.drivers.php 
    "db-name" => dirname(__DIR__) . "/app/sample-database.sqlite",
    "db-host" => "",
    "db-port" => null,                          //null for default port 
    "db-user" => "",
    "db-password" => "",
    "db-options" => null,                       //Example: [PDO::ATTR_PERSISTENT => true]. https://www.php.net/manual/en/pdo.construct.php 
    "db-error-mode" => PDO::ERRMODE_SILENT      //Specify the way you like to deal with DB Errors. See PDO::ATTR_ERRMODE on https://www.php.net/manual/en/pdo.setattribute.php
]; 