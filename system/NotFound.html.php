<?php
declare(strict_types = 1);
namespace Alddesign\EzMvc\System;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= htmlspecialchars($title) ?></title>
    </head>
    <body>
        <div style="text-align: center; font-family:'Courier New', Courier, monospace;">
            <h1><?= htmlspecialchars($title) ?></h1>
            <hr/>
            <p><?= htmlspecialchars($message) ?></p>
        </div>
    </body>
</html>