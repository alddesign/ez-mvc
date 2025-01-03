<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

class Route
{
    public string $path = '';
    public string $to = '';
    public bool $isDefault = false;
    public bool $isRegex = false;
    public bool $isStartsWith = false;


    private function __construct()
    {

    }

    /** @return Route */
    public static function newDefault(string $to)
    {
        $r = new Route();
        $r->isDefault = true;
        $r->to = $to;
        return $r;
    }

    /** @return Route */
    public static function newRegex(string $pathRegex, string $to)
    {
        $r = new Route();
        $r->isRegex = true;
        $r->path = $pathRegex;
        $r->to = $to;
        return $r;
    }

    /** @return Route */
    public static function newStartsWith(string $pathStartsWith, string $to)
    {
        $r = new Route();
        $r->isStartsWith = true;
        $r->path = $pathStartsWith;
        $r->to = $to;
        return $r;
    }

    /** @return Route */
    public static function new(string $path, string $to)
    {
        $r = new Route();
        $r->path = $path;
        $r->to = $to;
        return $r;
    }

	public function applies($path)
    {
        if($this->isDefault)
        {
            return true;
        }
        elseif($this->isRegex)
        {
            return preg_match($this->path, $path) === 1;
        }
        elseif($this->isStartsWith)
        {
            return str_starts_with($path, $this->path);
        }
 
        return $path === $this->path || Helper::addTrailingSlash($path) === Helper::addTrailingSlash($this->path);
    }
}