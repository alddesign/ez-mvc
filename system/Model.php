<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

use PDO;

/**
 * The model handles the DB connetion
 */
abstract class Model
{
    /** @var PDO */
    private static $pdo = null;

    private static function connect()
    {
        $dsn = '';
        $dbDriver = Config::systemNeed('db-driver');
        switch($dbDriver)
        {
            case 'sqlite': 
            {
                $dsn = sprintf('sqlite:%s', Config::systemNeed('db-name')); 
                break;
            }
            case 'sqlsrv': 
            {
                $port = Config::system('db-port', 0);
                $port = Helper::e($port, true) ? '' : sprintf(',%s', $port);
                $dsn = sprintf('sqlsrv:Server=%s%s;Database=%s', Config::systemNeed('db-host'), $port, Config::systemNeed('db-name'));
                break;
            }
            case 'mysql': 
            {
                $port = Config::system('db-port', 0);
                $port = Helper::e($port, true) ? '' : sprintf(';port=%s', $port);
                $dsn = sprintf('mysql:host=%s%s;dbname=%s', Config::systemNeed('db-host'), $port, Config::systemNeed('db-name'));
                break;
            }
            default : Helper::ex('Unsupported DB driver "%s".', $dbDriver);
        }

        self::$pdo = new PDO($dsn, Config::system('db-user', null), Config::system('db-password', null), Config::system('db-options', null));
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, Config::system('db-error-mode', PDO::ERRMODE_EXCEPTION));
    }

    /**
     * Connets to the DB and returns the PDO object.
     * @return PDO
     */
    public static function getPdo()
    {
        if(self::$pdo === null)
        {
            self::connect();
        }
        
        return self::$pdo;
    }

    /**
     * Formats the PDO errorInfo array as readable text.
     * 
     * @param array $errorInfo
     * 
     * @return string
     */
    protected static function formatErrorInfo(array $errorInfo)
    {
        if($errorInfo[0] === '00000')
        {
            return '';
        }
        else
        {
            return sprintf('Error during Database operation: %s-%s "%s".', strval($errorInfo[0]), strval($errorInfo[1]), strval($errorInfo[2]));
        }
    }
}