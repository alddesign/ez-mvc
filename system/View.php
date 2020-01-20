<?php
declare(strict_types = 1);
namespace Alddesign\DiceThemWords\System;

use Exception;

class View
{
    /** @var bool */
    public $isRootView = false;
    /** @var string */
    public $path = "";
    /** @var \DiceThemWords\View[] */
    public $parentViews = [];
    /** @var string */
    public $name = "";
    /** @var array */
    public $data = [];

    private const VIEWPATH = __DIR__."/../app/views/";

    private function __construct(string $name, array $data = [])
    {
        if(!is_string($name) || !preg_match('/^[a-zA-Z0-9_-]+$/', $name))
        {
            Helper::ex('Invalid view name "%s". Allowed characters: a-z,A-Z,0-9,_,-', $name);
        }

        if(!is_array($data))
        {
            Helper::ex('View data needs to be of type array.');
        }

        if(!file_exists(self::VIEWPATH . $name . ".view.php"))
        {
            Helper::ex('View "%s" not found.', $name);
        }

        $this->name = $name;
        $this->data = $data;
    }

    /** @return \DiceThemWords\View */
    public static function createRoot(string $name, array $data = [])
    {
        $view = new View($name, $data);

        $view->isRootView = true;
        $view->path = '/'.$name;
        $view->parentViews = [$view];
        $view->isRootView = true;

        return $view;
    }

    /** @return \DiceThemWords\View */
    public static function createChild(string $name, $parent, array $data = [])
    {
        $view = new View($name, $data);

        $view->isRootView = false;
        $view->path = $parent->path.'/'.$name;
        $view->parentViews = array_merge($parent->parentViews, [$view]);
        $view->isRootView = false;

        return $view;
    }

    /** @return \DiceThemWords\View */
    public function getRootView()
    {
        return $this->parentViews[0];
    }

    /** @return \DiceThemWords\View */
    public function getParentView(int $level = 0)
    {
        $c = count($this->parentViews) - 1;
        $level = $level > $c ? $level = 0 : $level;
        
        return $this->parentViews[$c - $level];
    }

    public function render()
    {
        extract($this->data);
        include(self::VIEWPATH . $this->name . ".view.php");
    }
}