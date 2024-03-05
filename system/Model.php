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
        $user = Helper::e(EZ_DB_USER, true) || !is_string(EZ_DB_USER) ? null : EZ_DB_USER;
        $password = Helper::e(EZ_DB_PASSWORD, true) || !is_string(EZ_DB_PASSWORD) ? null : EZ_DB_PASSWORD;
        $options = Helper::e(EZ_DB_OPTIONS, true) || !is_array(EZ_DB_OPTIONS) ? null : EZ_DB_OPTIONS;
        $errorMode = Helper::e(EZ_DB_ERROR_MODE, true) || !is_int(EZ_DB_ERROR_MODE) ? PDO::ERRMODE_EXCEPTION : EZ_DB_ERROR_MODE;

        switch(EZ_DB_DRIVER)
        {
            case 'sqlite': 
            {
                $dsn = sprintf('sqlite:%s', EZ_DB_NAME); 
                break;
            }
            case 'sqlsrv': 
            {
                $port = EZ_DB_PORT;
                $port = Helper::e($port, true) ? '' : sprintf(',%s', $port);
                $dsn = sprintf('sqlsrv:Server=%s%s;Database=%s', EZ_DB_HOST, $port, EZ_DB_NAME);
                break;
            }
            case 'mysql': 
            {
                $port = EZ_DB_PORT;
                $port = Helper::e($port, true) ? '' : sprintf(';port=%s', $port);
                $dsn = sprintf('mysql:host=%s%s;dbname=%s', EZ_DB_HOST, $port, EZ_DB_NAME);
                break;
            }
            default : Helper::ex('Unsupported DB driver "%s".', EZ_DB_DRIVER);
        }

        self::$pdo = new PDO($dsn, $user, $password, $options);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, $errorMode);
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