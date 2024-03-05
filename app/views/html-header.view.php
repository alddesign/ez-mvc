<?php 
namespace Alddesign\EzMvc;
use Alddesign\EzMvc\System\Config;
use Alddesign\EzMvc\System\View;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title><?php echo EZ_APP_NAME ?></title>
    </head>
    <body style="padding: 50px 0 0 0;">
    <?php View::createChild("title-bar", $this)->render(); ?> 