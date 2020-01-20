<?php
require (__DIR__.'/vendor/autoload.php'); //using composers autoload file:
session_start();

//Lets go:
Alddesign\DiceThemWords\System\Router::routeRequest();