<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\Controllers;

use Alddesign\EzMvc\Models\DefaultModel;
use Alddesign\EzMvc\System\Config;
use Alddesign\EzMvc\System\View;
use Alddesign\EzMvc\System\Controller;
use Alddesign\EzMvc\System\Helper;

/** Another Controller */
abstract class Product extends Controller
{
    public static function list()
    {
        $data = [];
        $data["products"] = DefaultModel::getProducts();

        View::createRoot("product-list", $data)->render();
    } 
    
    /**
     * Accessing url params:
     * First url param after Controller and Action is the $id (string)
     * All other url params are stored in $params (array)
     * (you can name these to function parameters the way out want!)
     */
    public static function setStatus($id, $params)
    {
        $id = intval($id);
        $active = $params[0] === "1" ? 1 : 0;

        DefaultModel::setProductActiveInactive($id, $active);//Update db record

        Helper::redirect("/Product/list"); //redirect to a specific url
    } 

    /** No paramters needed here, cause we use POST */
    public static function add()
    {
        /**
         * Check if all post parameters are set & have a value. Also they will be assigned to a variable.
         * Isnt that EZ?
         */
        if(!Helper::post("id", $id) || !Helper::post("name", $name) || !Helper::post("price", $price))
        {
            return "Missing data!";
        }

        $result = DefaultModel::addProduct(intval($id), $name, floatval($price));
        if($result !== true)
        {
            return $result;
        }

        Helper::redirect("/Product/list");
    }
}