<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc;

use Alddesign\EzMvc\System\Route;
use Alddesign\EzMvc\System\Router;


abstract class App
{
    
    /**
     * Gets call before user defined routes get applied to the request.
     * Here you can add custom routers to the Router class
     * 
     * @see \Alddesign\EzMvc\System\Router The Router class also has infos about the current request
     * @return void
     */
    public static function onRequestPreRoutes()
    {
        //Here you can reroute the request (this is not a redirect)
        Router::addRoute(Route::newStartsWith('/Main/products', '/Product/list'));
        Router::addRoute(Route::newRegex('/\/item.*/i', '/Product/list'));
    }

    /**
     * Gets called after the user defined routes get applied to the request.
     * 
     * @see \Alddesign\EzMvc\System\Router The Router class has infos about the current request
     * @return void
     */
    public static function onRequestPostRoutes()
    {

    }

    /**
     * Gets called after the routing and validation of the request url. At this point the request is valid (has controller and action)
     * 
     * @see \Alddesign\EzMvc\System\Router The Router class has infos about the current request
     * @return void
     */
    public static function onRequestPostValidate()
    {

    }
}