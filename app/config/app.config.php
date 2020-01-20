<?php

use Alddesign\DiceThemWords\DtwHelper;

$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "localhost";
$datetime = (new DateTime())->format('Ymd\THis');

$GLOBALS["_EZMVC_APP_CONFIG"] =
[
    "dice" => 
    [
        ["e","e","t","ö","u","p"],
        ["e","e","e","y","a","a"],
        ["e","e","i","i","ä","o"],
        ["e","i","f","h","d","ü"],
        ["n","n","d","g","t","r"],
        ["n","e","m","r","s","t"],
        ["b","l","n","qu","s","r"], //qu = q or qu
        ["x","w","z","k","j","v"],
        ["i","c","a","l","o","s"]
    ],
    "max-word-length" => 10,
    "min-word-length" => 4,
    "wss-port" => 8888,
    "wss-host" => $host === "localhost" ? "localhost" : "dtwmp.alddesign.at",
    "wss-javascript-log-enabled" => true,
    "wss-log-enabled" => true,
    "wss-logfile" => sprintf('%s/logs/%s-wss.log.txt', dirname(dirname(__DIR__)), $datetime),
    "wss-error-logfile" => sprintf('%s/logs/%s-wss.errorlog.txt', dirname(dirname(__DIR__)), $datetime),
    "wss-cli-stdout-file" => /*"", */sprintf('"%s/logs/wss-cli-start.log.txt"', dirname(dirname(__DIR__)) ), 
    "wss-cli-stderr-file" => /*"", */sprintf('"%s/logs/wss-cli-start.error.log.txt"', dirname(dirname(__DIR__)) ),
    "wss-session-id" => 'WSS-68ymzgkoJnQE0kDu',
    "wss-secret" => "QHFTnAtxprR5xO7r",
    "enable-signup-mail" => $host === "localhost" ? false : true,
    "activation-url" => "/Main/activation",
    "tables" => 
    [
        "Tokyo",
        "Osaka",
        "Nagoya",
        "Kyoto",
        "Nagasaki",
        "Sapporo",
        "Fukuoka",
        "Kobe"
    ]
];