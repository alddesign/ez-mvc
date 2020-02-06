<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

use Exception;
use PDO;
use PDOQuery;
use PDOStatement;

abstract class Model
{
    /** @var PDO */
    private static $pdo = null;
    private static $delimiters = [];

    private static function connect()
    {
        $dsn = "";
        switch(Config::system("db-driver"))
        {
            case "sqlite": 
            {
                self::$delimiters = ['"','"'];
                $dsn = sprintf('sqlite:%s', Config::system("db-name")); 
                break;
            }
            case "sqlsrv": 
            {
                self::$delimiters = ['[',']'];
                $port = Config::system("db-port", 0);
                $port = Helper::e($port, true) ? "" : "," . $port;
                $dsn = sprintf('sqlsrv:Server=%s%s;Database=%s', Config::system("db-host"), $port, Config::system("db-name"));
                break;
            }
            case "mysql": 
            {
                self::$delimiters = ['`','`'];
                $port = Config::system("db-port", 0);
                $port = Helper::e($port, true) ? "" : sprintf(';port=%s', $port);
                $dsn = sprintf('sqlsrv:host=%s%s;dbname=%s', Config::system("db-host"), $port, Config::system("db-name"));
                break;
            }
            default : Helper::ex('Unsupported DB driver "%s".', Config::system("db-driver"));
        }

        self::$pdo = new PDO($dsn, Config::system("db-user"), Config::system("db-password"), Config::system("db-options", null));
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, Config::system("db-error-mode", PDO::ERRMODE_SILENT));
    }

    /** @return string */
    protected static function delimiter(string $value)
    {
        return sprintf('%s%s%s', self::$delimiters[0], $value, self::$delimiters[1]);
    }

    /** @return array */
    protected static function getDelimiters()
    {
        return self::$delimiters;
    }

    /** @return PDO */
    protected static function getPdo()
    {
        if(self::$pdo === null)
        {
            self::connect();
        }
        
        return self::$pdo;
    }

    protected static function formatErrorInfo(array $errorInfo)
    {
        if($errorInfo[0] === "00000")
        {
            return "";
        }
        else
        {
            return sprintf('Error during Database operation: %s-%s "%s".', strval($errorInfo[0]), strval($errorInfo[1]), strval($errorInfo[2]));
        }
    }
}