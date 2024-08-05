<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();
$dotenv->ifPresent('APP_DEBUG')->isBoolean();

if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] == 1) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

define('DB_CONFIG', require __DIR__.'/../Config/database.php');