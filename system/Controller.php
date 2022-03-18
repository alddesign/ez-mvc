<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

/**
 * Controller base class. Controller classes have to extend it. Tbh it doesnt do much at this point...
 */
abstract class Controller
{
    public static function isController()
    {
        return true;
    }

    /**
     * Can be overridden in the App´s controller classes. Will be executed before the controller action is called.
     * 
     * @param string $action Name of the actions based on the url controller/action
     * @param string $id First urls parameter after controller/action
     * @param array $params All further paramters after controller/action/id
     * 
     * @return mixed If FALSE is returned, the request will be aborted (without any error)
     */
    public static function onRequest(string $action, string $id, array $params)
    {
        return true;
    }
}