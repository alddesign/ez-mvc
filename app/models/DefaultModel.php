<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\Models;

use Alddesign\EzMvc\System\Helper;
use Alddesign\EzMvc\System\Model;
use \PDO;

abstract class DefaultModel extends Model
{
    /** @return array|bool */
    public static function getProducts()
    {
        /*
        Use the PDO object to access your database (defined in system/system.config.php)
        */
        $pdo = self::getPDO();
        $result = $pdo->query('SELECT * FROM products;', PDO::FETCH_ASSOC);
        
        if($result === false)
        {
            return [];
        }
        else
        {
            return $result;
        }

    }

    /** @return array|bool */
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
     * Update data
     * @return bool
     */
    public static function setProductActiveInactive(int $id, int $active)
    {
        $statement = self::getPDO()->prepare('UPDATE products SET active = ? WHERE id = ?;');
        $params = [$active, $id];

        return $statement->execute($params);   
    }

        /**
     * Update data
     * @return bool
     */
    public static function addProduct(int $id, string $name, float $price, int $active = 0)
    {
        $statement = self::getPDO()->prepare('INSERT INTO products (id,name,price,active) VALUES(?,?,?,?)');

        if(!$statement->execute([$id, $name, $price, $active]))
        {
            return self::formatErrorInfo($statement->errorInfo(), "Error while creating new Product");
        } 

        return true;
    }
}