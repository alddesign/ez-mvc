<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\Models;

use Alddesign\EzMvc\System\Helper;
use Alddesign\EzMvc\System\Model;
use \PDO;

abstract class DefaultModel extends Model
{
    /**
     * Loads alls the products from the database
     *  
     * @return array 
     */
    public static function getProducts()
    {
        //Use the PDO object to access your database (defined in system/system.config.php)
        $pdo = self::getPDO();
        
        /** @var \PDOStatement $statement */
        $statement = $pdo->query('SELECT * FROM products;', PDO::FETCH_ASSOC);
        
        if($statement !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    /**
     * Loads a single product from the database
     * This could be used to create a detailed product page. Here its just to demonstrate how to load a single table row from the database.
     *  
     * @return array|bool 
     */
    public static function getProduct($id)
    {
        /** @var PDO */
        $pdo = self::getPDO();

        $query = 'SELECT * FROM products WHERE id = ?;';
        $params = [$id];
        $statement = $pdo->prepare($query);
        if($statement->execute($params))
        {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    /**
     * Set the status of a product
     * 
     * @return bool
     */
    public static function setProductActiveInactive(int $id, int $active)
    {
        $pdo = self::getPDO();

        $statement = $pdo->prepare('UPDATE products SET active = ? WHERE id = ?;');
        $params = [$active, $id];
        return $statement->execute($params); 
    }

    /**
     * Adds a new Product to the database
     * 
     * @return bool
     */
    public static function addProduct(int $id, string $name, float $price, int $active = 0)
    {
        //We forget about error handling, to keep this example simple
        $statement = self::getPDO()->prepare('INSERT INTO products (id,name,price,active) VALUES(?,?,?,?)');
        return $statement->execute([$id,$name,$price,$active]);
    }
}