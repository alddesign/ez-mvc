<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Config
{
    /** @var array The system config */
    private static array $sys = [];

    /** @var array The app config */
    private static array $app = [];

    private static bool $loaded = false;
    private static bool $found = false;


    /**
     * Loads a value from the app config (app.config.php). 
     * 
     * @param string $key The key for the config value. Supports dot syntax - see example. If $key is an empty string '' the whole app config will be returned.
     * @param string $default Retruns this default value, if no config value for $key was found.
     * 
     * @return mixed The config value for $key or $default if no config value for $key was found.
     * 
     * ```php
     * //Example of the dot syntax: these two call do the same.
     * $priceCaption = Config::get('captions.price');
     * //Is the same as
     * $priceCaption = Config::get('captions')['price'];
     * ```
     */
    public static function get(string $key = '', $default = '')
    {
        self::load();
        self::$found = true;

        if($key === '')
        {
            return self::$app;
        }

        //Try key as literal
        if(array_key_exists($key, self::$app))
        {
            return self::$app[$key];
        }

        //Try the dot syntax
        $dotkeys = explode('.', $key);
        $value = self::$app;
        foreach($dotkeys as $dotkey)
        {
            if(!is_array($value) || !array_key_exists($dotkey, $value))
            {
                self::$found = false;
                return $default;
            }

            $value = $value[$dotkey];
        }

        return $value;
    }


    /**
     * Works the same way as **Config::get()**, but stores the config value in $outVar. Returns if a config value for $key was found.
     * 
     * @param mixed &$outVar The config value will be stored in this variable (pass by reference);
     * @param string $default Default value for $outVar if no config value for $key was found.
     * 
     * @return bool TRUE if a config value for $key was found, otherwise FALSE.
     */
    public static function getVar(string $key, &$outVar, $default = '')
    {
        $outVar = self::get($key, $default);

        return self::$found;
    }

    /**
     * Works the same way as **Config::get()**, but throws an exception if no config value for $key was found.
     * 
     * @param bool $throwErrorIfEmpty Also throw an error if the config value is empty. 0 is not empty.
     * @throws Exception if no config value for $key was found.
     * 
     * @return mixed
     */
    public static function need(string $key, bool $throwErrorIfEmpty = false)
    {
        $value = self::get($key, '');

        if(!self::$found)
        {
            Helper::ex('Missing config value. Key "%s".', $key);
        }

        if($throwErrorIfEmpty && Helper::e($value))
        {
            Helper::ex('The config value must not be empty. Key "%s".', $key);
        }

        return $value;
    }

    /**
     * Checks if a config value for $key exists.
     * 
     * @return bool
     */
    public static function has(string $key)
    {
        self::get($key, '');

        return self::$found;
    }

    /**
     * Works the same way as **Config::get()**, but for the ez-mvc system config (system/system.config.php)
     */
    public static function system(string $key = '', $default = '')
    {
        self::load();
        self::$found = true;

        if($key === '')
        {
            return self::$sys;
        }

        //Try key as literal
        if(array_key_exists($key, self::$sys))
        {
            return self::$sys[$key];
        }

        //Try the dot syntax
        $dotkeys = explode('.', $key);
        $value = self::$sys;
        foreach($dotkeys as $dotkey)
        {
            if(!is_array($value) || !array_key_exists($dotkey, $value))
            {
                self::$found = false;
                return $default;
            }
            $value = $value[$dotkey];
        }

        return $value;
    }

    /**
     * Works the same way as **Config::getVar()**, but for the ez-mvc system config (system/system.config.php)
     */
    public static function systemVar(string $key, &$outVar, $default = '')
    {
        $outVar = self::system($key, $default);

        return self::$found;
    }

    /**
     * Works the same way as **Config::need()**, but for the ez-mvc system config (system/system.config.php)
     */
    public static function systemNeed(string $key, bool $throwErrorIfEmpty = false)
    {
        $value = self::system($key, '');

        if(!self::$found)
        {
            Helper::ex('Missing system-config value. Key "%s".', $key);
        }

        if($throwErrorIfEmpty && Helper::e($value))
        {
            Helper::ex('The system-config value must not be empty. Key "%s".', $key);
        }

        return $value;
    }

    /**
     * Works the same way as **Config::has()**, but for the ez-mvc system config (system/system.config.php)
     * 
     * @return bool
     */
    public static function systemHas(string $key)
    {
        self::system($key, '');

        return self::$found;
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
            self::$sys = require __DIR__ . '/system.config.php'; //Load config file
            if(!is_array(self::$sys))
            {
                Helper::ex('Config error. system.config.php has to return an array, %s given.', gettype(self::$sys));
            }

            self::$app = require dirname(__DIR__) . '/app/config/app.config.php';
            if(!is_array(self::$app))
            {
                Helper::ex('Config error. app.config.php has to return an array, %s given.', gettype(self::$app));
            }
        }
    }
}