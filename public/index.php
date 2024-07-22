<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Config/routes.php';

use App\Lib\Http\Router;
use App\Lib\Http\RequestData;
use App\Lib\Http\RequestParamHelper;

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