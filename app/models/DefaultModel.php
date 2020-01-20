<?php
declare(strict_types = 1);
namespace Alddesign\DiceThemWords\Models;

use Alddesign\DiceThemWords\System\Helper;
use Alddesign\DiceThemWords\System\Model;
use \PDO;

abstract class DefaultModel extends Model
{
    public static function hasWord(string $word)
    {
        $statement = self::getPDO()->prepare('SELECT COUNT(*) FROM "words" WHERE "value" = :value;');
        $statement->bindValue(':value', mb_strtolower($word));

        return $statement->execute() === true ? ($statement->fetchColumn() === '1') : false;
    }

    private static function getUser(string $id, string $email, int $active = null)
    {
        $id = mb_strtolower($id);
        
        if(!Helper::e($email))
        {
            if($active === null)
            {
                $query = 'SELECT * FROM users WHERE email = ?;';
                $params = [$email];
            }
            else
            {
                $query = 'SELECT * FROM users WHERE email = ? AND active = ?;';
                $params = [$email, $active];
            }
        }
        if(!Helper::e($id))
        {
            if($active === null)
            {
                $query = 'SELECT * FROM users WHERE id = ?;';
                $params = [$id];
            }
            else
            {
                $query = 'SELECT * FROM users WHERE id = ? AND active = ?;';
                $params = [$id, $active];
            }
        }

        $statement = self::getPDO()->prepare($query);
        if($statement->execute($params))
        {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        $errorInfo = self::getPDO()->errorInfo();
        return false;
    }

    public static function getUserPerMail(string $email, int $active = null)
    {
        return self::getUser("", $email, $active);
    }

    public static function getUserPerId(string $id, int $active = null)
    {
        return self::getUser($id, "", $active);
    }

    public static function createUser(string $id, string $email, string $passwordHash, string $activationCode)
    {
        $id = mb_strtolower($id);

        $statement = self::getPDO()->prepare('INSERT INTO users (id,password,email,active,activation_code,admin) VALUES (?,?,?,?,?,?);');
        $params = [$id, $passwordHash, $email, 0, $activationCode,0];

        return $statement->execute($params);   
    }

    public static function activateUser(string $id)
    {
        $id = mb_strtolower($id);

        $statement = self::getPDO()->prepare('UPDATE users SET active = ?, activation_code = ? WHERE id = ?;');
        $params = [1, "", $id];

        return $statement->execute($params);   
    }
}