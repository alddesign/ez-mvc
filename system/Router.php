<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

use Alddesign\EzMvc\App;

/**
 * Routing requests. 
 * 
 * The URL pattern is http://<base-url>/[<controller>]/[<action>]/[<id>]/[<param 1>]/[<param 2>]/[<param n>]
 */
abstract class Router
{
    /** @var RoutingData Data of the request (after routing) */
    public static $data = null;
    
    /** @var RoutingData Data of the original request */
    public static $originalData = null;
    /** @var Route The route that was applied to this request */
    public static $appliedRoute = null;
    
    /** @var Route[] */
    private static $routes = [];
    private static $fired = false;

    private const CONTROLLER_NAMESPACE = 'Alddesign\\EzMvc\\Controllers\\';


    /**
     * Resolves the request url and call the corrsponding Controller Action.
     * 
     * @return void
     */
    public static function routeRequest()
    {
        if(self::$fired)
        {
            return;
        }
        self::$fired = true;
        
        self::$data = self::resolveRequestUrl($_SERVER['REQUEST_URI']);
        self::$originalData = clone self::$data;

        App::onRequestPreRoutes();
        self::checkRoutes();
        App::onRequestPostRoutes();

        self::validateRequest();
        App::onRequestPostValidate();

        self::callControllerAction();
    }

    public static function addRoute(Route $route)
    {

        self::$routes[] = $route;
    }

    private static function checkRoutes()
    {
        foreach(self::$routes as $route)
        {
            if($route->applies(self::$data->path))
            {
                self::$appliedRoute = $route;
                self::$data = self::resolveRequestUrl($route->to);
                return;
            }
        }
    }

    private static function validateRequest()
    {
        $controllerClass = self::CONTROLLER_NAMESPACE . self::$data->controller;

        //Controller class exists, first call class_exists() to trigger autoload
        //Then check the declared classes again, to ensure case sensitivity
        if(!class_exists($controllerClass, true) || !in_array($controllerClass, get_declared_classes(), true))
        {
            self::returnError(404, 'Not Found', sprintf('The requested URL "%s" was not found.', $_SERVER['REQUEST_URI']));
        }

        //Class is a controller
        if(!is_subclass_of($controllerClass, __NAMESPACE__ . '\\Controller'))
        {
            self::returnError(500, 'Invalid Controller', sprintf('Class "%s" is not a valid controller.', self::$data->controller));
        }

        //Action (method) exists
        if(!in_array(self::$data->action, get_class_methods($controllerClass), true))
        {
            self::returnError(500, 'Invalid Action', sprintf('Action "%s" not found in controller class "%s".', self::$data->action, self::$data->controller));
        }
    }

    private static function callControllerAction()
    {
        //onRequest
        $result = call_user_func([self::CONTROLLER_NAMESPACE . self::$data->controller, 'onRequest'], self::$data->action,  self::$data->id, self::$data->params);
        if($result === false)
        {
            return;
        }

        //call to controller action method
        $result = call_user_func([self::CONTROLLER_NAMESPACE . self::$data->controller, self::$data->action], self::$data->id, self::$data->params); //Redirect to controller action
        $resultType = gettype($result);
        if(in_array($resultType, ['string','double','integer','boolean']))
        {
            echo $result;
        }
    }

    /**
     * Splits request url into $action, $id and $params.
     * 
     * @return RoutingData
     */
    public static function resolveRequestUrl(string $requestUri)
    {
        $data = new RoutingData();

        //Prepare request url   
        $reqPath = self::extractUrlPath('p://h.d' . Helper::addStartingSlash(urldecode($requestUri)));
        $data->requestPath = $reqPath;

        //Base Url:
        $basePath = Helper::removeTrailingSlash(self::extractUrlPath(EZ_BASE_URL));

        //Strip base url path from request url path:
        if($reqPath === $basePath || $reqPath === $basePath . '/')
        {
            $path = '/';
        }
        else
        {
            $path = str_starts_with($reqPath, $basePath . '/') ? '/' . mb_substr($reqPath, mb_strlen($basePath . '/')) : $reqPath;
        }
        $data->path = $path;

        //Default URL
        $path = $path === '/' ? Helper::addStartingSlash(EZ_DEFAULT_URL) : $path;

        //Split path into Controller, Action and params
        $pathParts = explode('/', $path);
        $data->controller = ($pathParts[1] ?? '') !== '' ? $pathParts[1] : '';
        $data->action = ($pathParts[2] ?? '') !== '' ? $pathParts[2] : '';
        $data->id = $pathParts[3] ?? '';
        $data->params = isset($pathParts[4]) ? array_slice($pathParts, 4) : [];

        return $data;
    }

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