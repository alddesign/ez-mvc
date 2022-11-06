<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\Controllers;

use Alddesign\EzMvc\System\View;
use Alddesign\EzMvc\System\Controller;

/**
 * This is a Controller.
 * The Controller name is the first segment of the url: http://localhost/Main/...
 */
abstract class Main extends Controller
{
    /**
     * This is an Controller Action.
     * The Controller Action name is the second segment of the url: http://localhost/Main/index/...
     */
    public static function index()
    {
        //When creating a view from a Controller action, make sure you create a ROOT view (and dont forget to render it!)
        View::createRoot("index")->render();
    }

}