<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../Config/app.php';
require __DIR__.'/../Config/routes.php';

use Lib\Http\Router;
use Lib\Http\Response;
use Lib\Http\TextRender;
use Lib\Http\RequestData;
use Lib\Http\RouteCollection;
use Lib\Http\MethodNotAllowedException;

$Router = new Router(RequestData::createFromGlobals(), RouteCollection::$routes);
try{
    $Controller = $Router->getMatchingController();
}catch(\Exception $Exception){
    if($Exception instanceof MethodNotAllowedException){
        Response::html((string) new TextRender(__DIR__ . '/405.html'), 405);
    }
}

// Execute the request controller or return a 404 error if the route doesn't exists
if(isset($Controller)){
    $Router->execute($Controller);
}else{
    Response::html((string) new TextRender(__DIR__ . '/404.html'), 404);
}
