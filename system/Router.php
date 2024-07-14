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
    private static $controller = '';
    private static $action = '';
    private static $id = '';
    private static $params = [];
    
    public static $defaultUrlApplied = false;
    public static $resolvedPath = '';
    
    private const CONTROLLER_NAMESPACE = 'Alddesign\\EzMvc\\Controllers\\';


    /**
     * Resolves the request url and call the corrsponding Controller Action.
     * 
     * @return void
     */
    public static function routeRequest()
    {
        self::resolveRequestUrl($_SERVER['REQUEST_URI']);
        
        //Validate
        $controllerExists = class_exists(self::CONTROLLER_NAMESPACE . self::$controller);
        if(!$controllerExists)
        {
            self::returnError(404, 'Not Found', sprintf('The requested URL "%s" was not found.', $_SERVER['REQUEST_URI']));
        }
        $isController = method_exists(self::CONTROLLER_NAMESPACE . self::$controller, 'onRequest');
        if(!$isController)
        {
            self::returnError(500, 'Invalid Controller', sprintf('Class "%s" is not a valid controller.', self::$controller));
        }

        $actionExists = method_exists(self::CONTROLLER_NAMESPACE . self::$controller, self::$action);
        if(!$actionExists)
        {
            self::returnError(500, 'Invalid Action', sprintf('Action "%s" not found in controller class "%s".', self::$action, self::$controller));
        }

        //Call controller & action
        self::callControllerAction();
    }

    private static function callControllerAction()
    {
        //onRequest
        $result = call_user_func([self::CONTROLLER_NAMESPACE . self::$controller, 'onRequest'], self::$action,  self::$id, self::$params);
        if($result === false)
        {
            return;
        }

        //call to controller action method
        $result = call_user_func([self::CONTROLLER_NAMESPACE . self::$controller, self::$action], self::$id, self::$params); //Redirect to controller action
        $resultType = gettype($result);
        if(in_array($resultType, ['string','double','integer','boolean']))
        {
            echo $result;
        }
    }

    /**
     * Splits request url into $action, $id and $params.
     * 
     * @return void
     */
    private static function resolveRequestUrl(string $requestUri)
    {
        //Prepare request url   
        $reqUrl = Helper::addStartingSlash($requestUri);
        $reqUrl = urldecode($reqUrl);
        $reqUrlPath = self::extractUrlPath('http://request.url' . $reqUrl);

        //Base Url:
        $baseUrl = Helper::addTrailingSlash(EZ_BASE_URL);
        $baseUrlPath = self::extractUrlPath($baseUrl);

        //Strip base url path from request url path:
        $path = mb_strpos($reqUrlPath, $baseUrlPath) === 0 ? '/' . mb_substr($reqUrlPath, mb_strlen($baseUrlPath)) : $reqUrlPath;

        //Default URL
        if($path === '/')
        {
            self::$defaultUrlApplied = true;
            $path = Helper::addStartingSlash(EZ_DEFAULT_URL);
        }

        //Split path into Controller, Action and params
        $pathParts = explode('/', $path);
        self::$resolvedPath = $path;
        self::$controller = isset($pathParts[1]) && $pathParts[1] !== '' ? $pathParts[1] : '';
        self::$action = isset($pathParts[2]) && $pathParts[2] !== '' ? $pathParts[2] : '';
        self::$id = isset($pathParts[3]) ? $pathParts[3] : '';
        self::$params = isset($pathParts[4]) ? array_slice($pathParts, 4) : [];

        return;
    }

    /** @return string */
    private static function extractUrlPath(string $url)
    {
        $parts = parse_url($url);
        return $parts !== FALSE ? ($parts['path'] ?? '/') : '/';
    }

    /**
     * Calls NotFound.html.php with specified http response code, title and message and end the request.
     */
    private static function returnError(int $httpResponseCode, string $title, string $message) 
    {
        http_response_code($httpResponseCode);
        require(__DIR__ . '/NotFound.html.php');
        die;
    }
}