<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Config
{
    public static function get(string $key = "", $default = "")
    {
        global $_EZMVC_APP_CONFIG;

        if(!isset($_EZMVC_APP_CONFIG))
        {
            self::load();
            global $_EZMVC_APP_CONFIG;
        }

        if($key === "")
        {
            return $_EZMVC_APP_CONFIG;
        }

        return isset($_EZMVC_APP_CONFIG[$key]) ? $_EZMVC_APP_CONFIG[$key] : $default;
    }

    public static function system(string $key = "", $default = "")
    {
        global $_EZMVC_SYS_CONFIG;

        if(!isset($_EZMVC_SYS_CONFIG))
        {
            self::load();
            global $_EZMVC_SYS_CONFIG;
        }

        if($key === "")
        {
            return $_EZMVC_SYS_CONFIG;
        }

        return isset($_EZMVC_SYS_CONFIG[$key]) ? $_EZMVC_SYS_CONFIG[$key] : $default;
    }

    public static function load()
    {
        require __DIR__ . '/system.config.php';
        require dirname(__DIR__) . '/app/config/app.config.php';
    }
}