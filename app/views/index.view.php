<?php 
namespace Alddesign\DiceThemWords; 
use Alddesign\DiceThemWords\System\Config;
use Alddesign\DiceThemWords\System\Helper;
use Alddesign\DiceThemWords\System\View;

$bodyclass = isset($this->getRootView()->data["bodyclass"]) ? $this->getRootView()->data["bodyclass"] : "";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <meta name="description" content="Dice them Words">
        <meta property="og:title" content="Dice them Words">
        <meta property="og:description" content="I am tired of typing shit...">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://dtw.alddesign.at">
        <meta property="og:image" content="http://dtw.alddesign.at/assets/img/ms-icon-150x150.png">

        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Helper::url("/assets/img/favicon-32x32.png"); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Helper::url("/assets/img/favicon-96x96.png"); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Helper::url("/assets/img/favicon-16x16.png"); ?>">
        
        <script src="<?php Helper::echoUrl("/assets/jquery/jquery.min.js"); ?>"></script>
        <script src="<?php Helper::echoUrl("/assets/metro/js/metro.min.js"); ?>"></script>
        <script id="dtw-script">
            <?php echo sprintf('var dtwBaseUrl = "%s";', Config::system("base-url")); ?>
        </script>
        <script src="<?php Helper::echoUrl("assets/jquery/jquery.cookie.js"); ?>"></script>
        <script src="<?php Helper::echoUrl("/assets/js/dtw.default.js"); ?>"></script>
        <?php
            $jsFile = '/assets/js/' . $this->getRootView()->name . '.js';
            if(file_exists(dirname(dirname(__DIR__)) . $jsFile))
            {
                echo sprintf('<script src="%s"></script>%s', Helper::url($jsFile), "\n");
            }
        ?>

        <link rel="stylesheet" href="<?php Helper::echoUrl("/assets/metro/css/metro-all.min.css"); ?>">
        <link rel="stylesheet" href="<?php Helper::echoUrl("/assets/css/dtw.default.css"); ?>">
        <?php
            $cssFile = '/assets/css/' . $this->getRootView()->name . '.css';
            if(file_exists(dirname(dirname(__DIR__))  . $cssFile))
            {
                echo sprintf('<link rel="stylesheet" href="%s">%s', Helper::url($cssFile), "\n");
            }
        ?>

        <title>Dice them Words [v2.0.0-alpha.1]</title>
    </head>
    <body class="<?php echo $bodyclass; ?>">
        <?php View::createChild("app-bar", $this)->render(); ?>