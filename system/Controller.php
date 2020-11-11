<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

/**
 * Controller base class. Controller classes have to extend it. Tbh it doesnt do much at this point...
 */
abstract class Controller
{
    protected static function isController()
    {
        return true;
    }
}