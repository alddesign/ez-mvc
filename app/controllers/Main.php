<?php
declare(strict_types = 1);
namespace Alddesign\DiceThemWords\Controllers;

use Alddesign\DiceThemWords\DtwHelper;
use Alddesign\DiceThemWords\Models\DefaultModel;
use Alddesign\DiceThemWords\System\Config;
use Alddesign\DiceThemWords\System\View;
use Alddesign\DiceThemWords\System\Controller;
use Alddesign\DiceThemWords\System\Helper;
use Alddesign\DiceThemWords\WebSocketClient;

abstract class Main extends Controller
{
    public static function index()
    {
        Helper::session("login", $login, false);
        if($login)
        {
            Helper::redirect("/Main/tables");
        }
        else
        {
            Helper::redirect("/Main/login");
        }
    }   

    public static function db()
    {
        Helper::session("admin", $admin, false);
        if($admin !== true)
        {
            return;
        }

        require dirname(dirname(__DIR__)) . '/phpliteadmin/index.php';
    }

    public static function play($tablename)
    {
        DtwHelper::checkLogin();

        DtwHelper::switchToSession(Config::get("wss-session-id"));
        $wssData = $_SESSION;
        DtwHelper::switchBackToOriginalSession();

        //Wss not running
        if($wssData === [])
        {
            $data =
            [
                "icon" => "heart-broken",
                "title" => "Gameserver offline",
                "message" => "Websocket server is not running. Ask TheD or so.",
                "linkurl" => Helper::url("/"),
                "linktext" => "Damn",
                "linkclass" => "alert"
            ];

            View::createRoot("message", $data)->render();
            return;
        }

        //Table not found
        if(!isset($wssData["tables"][$tablename]))
        {
            $data =
            [
                "icon" => "warning",
                "title" => "Table not found",
                "message" => sprintf('It seems like the table "%s" doesnt exist.', $tablename),
                "linkurl" => Helper::url("/Main/tables"),
                "linktext" => "Back",
            ];
            
            View::createRoot("message", $data)->render();
            return;
        }
        
        //Table not open
        $table = $wssData["tables"][$tablename];
        if(!$table["open"])
        {
            $data =
            [
                "icon" => "lock",
                "title" => "Table closed",
                "message" => sprintf('"%s" is closed. Come back later or join another table.', $tablename),
                "linkurl" => Helper::url("/Main/tables"),
                "linktext" => "Back",
            ];
            
            View::createRoot("message", $data)->render();
            return;
        }

        $data = 
        [
            "table" => $table["name"],
            "userId" => $_SESSION["userid"]
        ];

        View::createRoot("play", $data)->render();
    }

    public static function tables()
    {
        DtwHelper::checkLogin();

        DtwHelper::switchToSession(Config::get("wss-session-id"));
        $data = $_SESSION;
        DtwHelper::switchBackToOriginalSession();

        if($data === [])
        {
            $data =
            [
                "icon" => "heart-broken",
                "title" => "Gameserver offline",
                "message" => "Websocket server is not running. Ask TheD or so.",
                "linkurl" => Helper::url("/"),
                "linktext" => "Damn",
                "linkclass" => "alert"
            ];

            View::createRoot("message", $data)->render();
            return;
        }

        View::createRoot("tables", $data)->render();
    }

    public static function login()
    {
        View::createRoot("login")->render();
    } 

    public static function signup()
    {
        View::createRoot("signup")->render();
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);

        Helper::redirect("/");
    }

    public static function signupSuccess()
    {
        $userId = isset($_SESSION["userid"]) ? $_SESSION["userid"] : "";
        $email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";

        $message = "";
        if(Config::get("enable-signup-mail", false))
        {
            $message = sprintf('Your DtW username: <b>%s</b><br>Your email: <b>%s</b><br>Please check you emails to activate your account.', $userId, $email);
        }
        else
        {
            $message = sprintf('Your DtW username: <b>%s</b><br>Please ask The f*cking D to activate your account.', $userId);
        }

        $data =
        [
            "icon" => "user-check",
            "title" => "Signup successful",
            "message" => $message,
            "linkurl" => Helper::url("/"),
            "linktext" => "Home",
            "linkclass" => "primary"
        ];

        View::createRoot("message", $data)->render();
    }

    public static function activation($userId, $params)
    {
        $activationCode = isset($params[0]) ? $params[0] : ""; 
        if(Helper::e($userId) || Helper::e($activationCode))
        {
            return;
        }

        $user = DefaultModel::getUserPerId($userId, 0);
        if($user === false || $user["activation_code"] !== $activationCode)
        {
            return;
        }

        if(DefaultModel::activateUser($userId) === false)
        {
            return;
        }

        $data =
        [
            "icon" => "user-check",
            "title" => "Activation completed.",
            "message" => "Your activation was successful. You can now log-in to you profile.",
            "linkurl" => Helper::url("/Main/login"),
            "linktext" => "Login",
            "linkclass" => "primary"
        ];
        View::createRoot("message", $data)->render();
    }
}