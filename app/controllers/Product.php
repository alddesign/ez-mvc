<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\Controllers;

use Alddesign\EzMvc\Models\DefaultModel;
use Alddesign\EzMvc\System\View;
use Alddesign\EzMvc\System\Controller;
use Alddesign\EzMvc\System\Helper;
use Alddesign\EzMvc\System\Request;

/** Another Controller */
abstract class Product extends Controller
{
    /**
     * Most basic type of a Controller Action.
     */
    public static function list()
    {
        $data = [];
        $data["products"] = DefaultModel::getProducts();

        View::createRoot("product-list", $data)->render();
    }

    /**
     * Shows a detailed page for a single product.
     * 
     * Accessing url segments (GET requests):
     * First url segment after /<Controller>/<Action>/ is accessible by the first parameter of this method here.
     * All following url segments are stored in the second parameter of this method(as string array)
     * (you can name these parameters the way out want and you dont have to decalare them, if not needed)
     * 
     * Normal url parameters (?param=1&status=on for example) can be access by Request::get() or by traditional $_GET;
     */
    public static function card($id)
    {   
        $product = DefaultModel::getProduct((string)$id);

        if($product === false)
        {
            //Any text or number you return will be echoed out:
            return "Product $id not found.";
        }

        View::createRoot("product-card", ["product" => (object)$product])->render();
    }
    
    /**
     * @param string $id Holds the id of the product
     * @param string[] $params Holds "1" or "0" at pos [0] - active or inactive
     */
    public static function setStatus($id, $params)
    {
        $id = intval($id);
        $active = $params[0] === "1" ? 1 : 0;

        DefaultModel::setProductActiveInactive($id, $active);//Update db record

        Helper::redirect("/Product/list"); //redirect to a specific url
    } 

    /** 
     * We dont need to add parameters to this action, because it is a POST request. 
     * Parameters are only accessible in GET requests, based on the URL.
     */
    public static function add()
    {
        /**
         * Check if all post parameters are set & have a value. Also they will be assigned to a variable.
         * Isnt that EZ?
         */
        if(!Request::post("id", $id) || !Request::post("name", $name) || !Request::post("price", $price))
        {
            return "Missing data!";
        }

        $result = DefaultModel::addProduct(intval($id), $name, floatval($price));

        Helper::redirect("/Product/list");
    }

    /**
     * "onRequest" is a special controller action which lets you intercept every request made to this controller. 
     * This method is called before the action method is called. You can prevent the excution of the action by returning FALSE.
     * 
     * @param string $action The name of the controller action requested (based on url)
     * @param string $id First url segment
     * @param array $params Other urls segments
     * 
     * @return bool return FALSE to prevent the execution of the original controller action
     */
    public static function onRequest(string $action, string $id, array $params)
    {
        if($action === "card")
        {
            echo "Not yet implemented! - This is an example of the special controller action onRequest(). See /app/controllers/Product.php";
            return false;
        }
    }
}