<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Config
{
    
    /**
     * Loads a value from the app.config.php. You can access the config via the dot syntax (separating keys with a '.')
     * 
     * ```php
     * //Example
     * Config::get('captions.price');
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
        if(isset($_EZMVC_APP_CONFIG[$key]))
        {
            return $_EZMVC_APP_CONFIG[$key];
        }

        //Try the dot syntax
        $keys = explode('.', $key);
        $value = $_EZMVC_APP_CONFIG;
        foreach($keys as $k)
        {
            if(!isset($value[$k]))
            {
                return $default;
            }
            $value = $value[$k];
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
        if(isset($_EZMVC_SYS_CONFIG[$key]))
        {
            return $_EZMVC_SYS_CONFIG[$key];
        }

        //Try the dot syntax
        $keys = explode('.', $key);
        $value = $_EZMVC_SYS_CONFIG;
        foreach($keys as $k)
        {
            if(!isset($value[$k]))
            {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    public static function load()
    {
        require_once __DIR__ . '/system.config.php';
        require_once dirname(__DIR__) . '/app/config/app.config.php';
    }
}