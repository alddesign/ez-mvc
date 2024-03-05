<?php
/**
 * This is the ez-mvc system config file.
 * Do not add or remove any of the constants here.
 * Do not add any other code here - your app has a separate config file in /app/config/app.config.php
 */

define('EZ_APP_NAME', 'EZ MVC Sample App'); //The name of your app
define('EZ_BASE_URL', 'http://localhost/ez-mvc/'); //The url pointing to the root directory of EZ-MVC (where the index.php is located)
define('EZ_DEFAULT_CONTROLLER', 'Main'); //The default controller (class name) when none is specified
define('EZ_DEFAULT_ACTION', 'index'); //The default action (method name in the controller class) when none is specified
define('EZ_DEFAULT_TIMEZONE', 'Europe/Vienna'); //PHP Timezone. See: https://www.php.net/manual/de/timezones.php 
define('EZ_DB_DRIVER', 'sqlite');//The DB driver: 'mysql', 'sqlite' and 'sqlsrv' are supported for now. See: https://www.php.net/manual/en/pdo.drivers.php  
define('EZ_DB_NAME', dirname(__DIR__) . '/app/sample-database.sqlite'); //The name of the database or path to the file in case of sqlite
define('EZ_DB_HOST', ''); //The hostname/ip of the DB server. Empty if not needed.
define('EZ_DB_PORT', 0); //DB Port. 0 for default port or if not needed.
define('EZ_DB_USER', ''); //DB username. Empty if not needed
define('EZ_DB_PASSWORD', ''); //DB Password. Empty if not need
define('EZ_DB_OPTIONS', [PDO::ATTR_PERSISTENT, true]); //PHP PDO DB options. See: https://www.php.net/manual/en/pdo.construct.php
define('EZ_DB_ERROR_MODE', PDO::ERRMODE_EXCEPTION); //Specify the way you like to deal with DB Errors. ERRMODE_EXCEPTION is recommended, as it is also the default in php8.x. See: PDO::ATTR_ERRMODE on https://www.php.net/manual/en/pdo.setattribute.php 
define('EZ_PHP_DISPLAY_ERRORS', 'On'); //'On' or 'Off'. Specify if PHP shows runtime errors at all. See: https://www.php.net/manual/en/errorfunc.configuration.php#ini.display-errors 
define('EZ_PHP_DISPLAY_STARTUP_ERRORS', 'On'); //'On' or 'Off'. Specify if PHP shows startup errors. See: https://www.php.net/manual/en/errorfunc.configuration.php#ini.display-startup-errors
define('EZ_PHP_ERROR_REPORTING', -1); //PHP error reporting level. See: https://www.php.net/manual/en/function.error-reporting.php
define('EZ_VERSION', 'v1.0.0-beta.4'); //Version of ez-mvc (just in case u wanna know) 
