<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

/**
 * Routing requests. 
 * 
 * The URL pattern is http://<base-url>/[<controller>]/[<action>]/[<id>]/[<param 1>]/[<param 2>]/[<param n>]
 */
abstract class Router
{
    private static $originalRequestUrl = '';
    private static $controller = '';
    private static $action = '';
    private static $id = '';
    private static $params = [];
    private const CONTROLLER_NAMESPACE = 'Alddesign\\EzMvc\\Controllers\\';


    /**
     * Resolves the request url and call the corrsponding Controller Action.
     * 
     * @return void
     */
    public static function routeRequest()
    {
        self::resolveRequestUrl();
        
        if(!method_exists(self::CONTROLLER_NAMESPACE . self::$controller, self::$action))
        {
            Helper::ex('Invalid URL "%s".', self::$originalRequestUrl);
        }

        if(!method_exists(self::CONTROLLER_NAMESPACE . self::$controller, 'isController'))
        {
            Helper::ex('Invalid controller "%s".', self::$controller);
        }

        //onRequest
        $result = call_user_func([self::CONTROLLER_NAMESPACE . self::$controller, 'onRequest'], self::$action,  self::$id, self::$params);
        if($result === false)
        {
            return;
        }

        //call to controller action method
        $result = call_user_func([self::CONTROLLER_NAMESPACE . self::$controller, self::$action], self::$id, self::$params); //Redirect to controller action

        if(in_array(gettype($result), ['string','double','integer','boolean']))
        {
            echo $result;
        }
    }

    /**
     * Splits request url into $action, $id and $params.
     * 
     * @return void
     */
    private static function resolveRequestUrl()
    {      
        //Request Url:
        $url = parse_url(Helper::addTrailingSlash('http://example.com' . urldecode($_SERVER['REQUEST_URI'])));
        $urlPath = isset($url['path']) ? $url['path'] : '/';
        self::$originalRequestUrl = $urlPath;

        //Base Url:
        $baseUrl = parse_url(Helper::addTrailingSlash(EZ_BASE_URL));
        $baseUrlPath = isset($baseUrl['path']) ? $baseUrl['path'] : '/';

        //Strip base url path from request url path:
        $urlPath = mb_strpos($urlPath, $baseUrlPath, 0) === 0 ? '/' . mb_substr($urlPath, mb_strlen($baseUrlPath)) : $urlPath;

        //Split request url path:
        $urlPathParts = explode('/', $urlPath);

        self::$controller = isset($urlPathParts[1]) && $urlPathParts[1] !== '' ? $urlPathParts[1] : EZ_DEFAULT_CONTROLLER;
        self::$action = isset($urlPathParts[2]) && $urlPathParts[2] !== '' ? $urlPathParts[2] : EZ_DEFAULT_ACTION;
        self::$id = isset($urlPathParts[3]) ? $urlPathParts[3] : '';
        self::$params = isset($urlPathParts[4]) ? array_slice($urlPathParts, 4) : [];
    }
}