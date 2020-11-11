<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;

use Exception;

/**
 * View are used to display data.
 */
class View
{
    /** @var bool */
    public $isRootView = false;
    /** @var string */
    public $path = "";
    /** @var View[] */
    public $parentViews = [];
    /** @var string */
    public $name = "";
    /** @var array */
    public $data = [];

    private const VIEWPATH = __DIR__."/../app/views/";

    /**
     * Creates a new View
     * 
     * @param string $name
     * @param array $data
     */
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

    /**
     * Creates a root view. A root can have subsidiary "child views". So the root view is the very "inner" part of a page, while child views are outer parts like a header, footer, menu...
     * @param string $name
     * @param array $data
     * 
     * @return View
     */
    public static function createRoot(string $name, array $data = [])
    {
        $view = new View($name, $data);

        $view->isRootView = true;
        $view->path = '/'.$name;
        $view->parentViews = [$view];
        $view->isRootView = true;

        return $view;
    }

    /**
     * Creates a child view. Child views can be included into a root view or even other child views.
     * @param string $name
     * @param View The view in which this child view is included
     * @param array $data
     * 
     * @return View
     */
    public static function createChild(string $name, $parentView, array $data = [])
    {
        $view = new View($name, $data);

        $view->isRootView = false;
        $view->path = $parentView->path.'/'.$name;
        $view->parentViews = array_merge($parentView->parentViews, [$view]);
        $view->isRootView = false;

        return $view;
    }

    /**
     * Returns the root view for a child view.
     * 
     * @return View
     */
    public function getRootView()
    {
        return $this->parentViews[0];
    }

    /**
     * Returns the parent view for this child view. This can be the root view or other child views in the hierachy.
     * 
     * @param int $level Specifiy this level to get a parent view based on the hierarchy of your root + child views. 0 = direct parent, 1 = parent of parent,...
     * 
     * @return View
     */
    public function getParentView(int $level = 0)
    {
        $c = count($this->parentViews) - 1;
        $level = $level > $c ? $level = 0 : $level;
        
        return $this->parentViews[$c - $level];
    }

    /**
     * Echos this view to the browser.
     * 
     * @return void
     */
    public function render()
    {
        extract($this->data);
        include(self::VIEWPATH . $this->name . ".view.php");
    }
}