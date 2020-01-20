<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

abstract class Controller
{
    protected static function isController()
    {
        return true;
    }
}