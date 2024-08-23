<?php

require __DIR__.'/../Config/routes.php';

use Lib\Http\Router;
use Lib\Http\Response;
use Lib\Http\RouteCollection;
use Lib\Http\Helper\RequestData;
use Lib\Http\Exception\MethodNotAllowedException;

$_ENV['APP_DEBUG'] ??= 0;

try {
    $Router = new Router(RequestData::createFromGlobals(), RouteCollection::$routes);
    $Controller = $Router->getMatchingController();

    // Execute the request controller or return a 404 error if the route doesn't exists
    if (isset($Controller)) {
        $Response = $Router->execute($Controller);
    } else {
        $Response = Response::template(__DIR__.'/../public/404.html', 404);
    }
} catch (\Exception $Exception) {
    if ($Exception instanceof MethodNotAllowedException) {
        $Response = Response::template(__DIR__.'/../public/405.html', 405);
    } else if($_ENV['APP_DEBUG'] == 0) {
        $Response = Response::template(__DIR__.'/../public/500.html', 500);
    }else{
        $Response = Response::html($Exception, 500);
    }
}

return $Response->render();
