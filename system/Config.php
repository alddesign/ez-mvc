<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Config
{
    private static $loaded = false;

    /**
     * Loads a value from the app.config.php. You can access the config via the dot syntax (separating keys with a '.')
     * 
     * ```php
     * //Example
     * Config::get('captions.price');
     * //Is the same as
     * Config::get('captions')['price'];
     * ```
     * @param string $key
     * @param string $default Default value if key is not found
     * 
     * @return mixed
     */
    public static function get(string $key = '', $default = '')
    {
        global $_EZMVC_APP_CONFIG;

        if($key === '')
        {
            return $_EZMVC_APP_CONFIG;
        }

        //Try key as literal
        if(array_key_exists($key, $_EZMVC_APP_CONFIG))
        {
            return $_EZMVC_APP_CONFIG[$key];
        }

        //Try the dot syntax
        $dotkeys = explode('.', $key);
        $value = $_EZMVC_APP_CONFIG;
        foreach($dotkeys as $dotkey)
        {
            if(!is_array($value) || !array_key_exists($dotkey, $value))
            {
                return $default;
            }

            $value = $value[$dotkey];
        }

        return $value;
    }

    /**
     * Loads a value from the ez-mvc system.config.php. Works the same way as Config::get()
     * 
     * @param string $key
     * @param string $default Default value if key is not found
     * 
     * @return mixed
     */
    public static function system(string $key = '', $default = '')
    {
        global $_EZMVC_SYS_CONFIG;

        if($key === '')
        {
            return $_EZMVC_SYS_CONFIG;
        }

        //Try key as literal
        if(array_key_exists($key, $_EZMVC_SYS_CONFIG))
        {
            return $_EZMVC_SYS_CONFIG[$key];
        }

        //Try the dot syntax
        $dotkeys = explode('.', $key);
        $value = $_EZMVC_SYS_CONFIG;
        foreach($dotkeys as $dotkey)
        {
            if(!is_array($value) || !array_key_exists($dotkey, $value))
            {
                return $default;
            }
            $value = $value[$dotkey];
        }

        return $value;
    }

    /**
     * Loads the config files into the global vars
     * 
     * @return void
     */
    public static function load()
    {
        if(!self::$loaded)
        {
            $GLOBALS['_EZMVC_SYS_CONFIG'] = require __DIR__ . '/system.config.php'; //Load config file
            $GLOBALS['_EZMVC_SYS_CONFIG'] = is_array($GLOBALS['_EZMVC_SYS_CONFIG']) ? $GLOBALS['_EZMVC_SYS_CONFIG'] : []; //Make sure its an array

            $GLOBALS['_EZMVC_APP_CONFIG'] = require dirname(__DIR__) . '/app/config/app.config.php';
            $GLOBALS['_EZMVC_APP_CONFIG'] = is_array($GLOBALS['_EZMVC_APP_CONFIG']) ? $GLOBALS['_EZMVC_APP_CONFIG'] : [];
        }
    }
}