<?php
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "localhost";
    
    $GLOBALS["_EZMVC_SYS_CONFIG"] =
    [
        "base-url" => $host === "localhost" ? "http://localhost/dice-them-words" : "http://dtwmp.alddesign.at",
        "default-controller" => "Main",
        "default-action" => "index",
        "db-driver" => 'sqlite',
        "db-name" => dirname(__DIR__) . '/app/db/db.sqlite',
        "db-host" => "",
        "db-port" => 0,
        "db-user" => "",
        "db-password" => ""
    ]; 