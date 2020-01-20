<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

use Exception;
use \PDO;

abstract class Model
{
    /** @var \PDO */
    private static $Pdo = null;

    private static function connect()
    {
        $dsn = "";
        switch(Config::system("db-driver"))
        {
            case "sqlite": $dsn = sprintf('sqlite:%s', Config::system("db-name")); break;
            case "sqlsrv": 
            {
                $port = Config::system("db-port", 0);
                $port = Helper::e($port, true) ? "" : "," . $port;
                $dsn = sprintf('sqlsrv:Server=%s%s;Database=%s', Config::system("db-host"), $port, Config::system("db-name"));
                break;
            }
            case "mysql": 
            {
                $port = Config::system("db-port", 0);
                $port = Helper::e($port, true) ? "" : sprintf(';port=%s', $port);
                $dsn = sprintf('sqlsrv:host=%s%s;dbname=%s', Config::system("db-host"), $port, Config::system("db-name"));
                break;
            }
            default : Helper::ex('Unsupported DB driver "%s".', Config::system("db-driver"));
        }

        self::$Pdo = new PDO($dsn, Config::system("db-user"), Config::system("db-password"), Config::system("db-options", null));
        self::$Pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /** @return \PDO */
    protected static function getPDO()
    {
        if(self::$Pdo === null)
        {
            self::connect();
        }
        
        return self::$Pdo;
    }

    /** @return array */
    protected static function getErrorInfo()
    {        
        return self::$Pdo->errorInfo();
    }
}