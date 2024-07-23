<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../Config/routes.php';

use Dotenv\Dotenv;
use Lib\Http\Router;
use Lib\Http\RequestData;
use Lib\Http\RequestParamHelper;

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();
$dotenv->ifPresent('APP_DEBUG')->isBoolean();
define('DB_CONFIG', require __DIR__ . '/../Config/database.php');

if (isset($_ENV['APP_DEBUG']) && 1 == $_ENV['APP_DEBUG']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
}else{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

$RequestData = new RequestData(
    headers: getallheaders(),
    body: json_decode(file_get_contents('php://input'), true),
    params: (new RequestParamHelper($_SERVER['QUERY_STRING'] ?? ''))->Params,
    method: $_SERVER['REQUEST_METHOD'],
    uri: $_SERVER['REQUEST_URI'] ?? '/',
);

// Route the request or return a 404 error if the route is not found
if (!Router::route($RequestData)) {
    header('HTTP/1.0 404 Not Found');
    require __DIR__ . '/404.html';
}