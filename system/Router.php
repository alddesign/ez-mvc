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

    public static function routeRequest()
    {
        self::resolveRequestUrl();
        
        if(!method_exists(self::CONTROLLER_NAMESPACE . self::$controller, self::$action))
        {
            Helper::ex('Invalid URL "%s".', self::$originalRequestUrl);
        }

        if(!method_exists(self::CONTROLLER_NAMESPACE . self::$controller, "isController"))
        {
            Helper::ex('Invalid controller "%s".', self::$controller);
        }

        $result = call_user_func(sprintf('%s%s::%s', self::CONTROLLER_NAMESPACE, self::$controller, self::$action), self::$id, self::$params); //Redirect to controller action
        $restype = gettype($result);

        if($restype === 'string' || $restype === 'double' || $restype === 'integer' || $restype === 'boolean')
        {
            echo $result;
        }
    }

    /**
     * Resolves request url into $action, $id and $params.
     */
    private static function resolveRequestUrl()
    {      
        //Request Url:
        $url = parse_url(Helper::addTrailingSlash("http://example.com" . urldecode($_SERVER["REQUEST_URI"])));
        $urlPath = isset($url["path"]) ? $url["path"] : "/";
        self::$originalRequestUrl = $urlPath;

        //Base Url:
        $baseUrl = parse_url(Helper::addTrailingSlash(Config::system("base-url")));
        $baseUrlPath = isset($baseUrl["path"]) ? $baseUrl["path"] : "/";

        //Strip base url path from request url path:
        $urlPath = mb_strpos($urlPath, $baseUrlPath, 0) === 0 ? "/" . mb_substr($urlPath, mb_strlen($baseUrlPath)) : $urlPath;

        //Split request url path:
        $urlPathParts = explode("/", $urlPath);

        self::$controller = isset($urlPathParts[1]) && $urlPathParts[1] !== "" ? $urlPathParts[1] : Config::system("default-controller");
        self::$action = isset($urlPathParts[2]) && $urlPathParts[2] !== "" ? $urlPathParts[2] : Config::system("default-action");
        self::$id = isset($urlPathParts[3]) ? $urlPathParts[3] : "";
        self::$params = isset($urlPathParts[4]) ? array_slice($urlPathParts, 4) : [];
    }
}