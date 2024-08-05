<?php

require __DIR__.'/../Config/routes.php';

use Lib\Http\MethodNotAllowedException;
use Lib\Http\RequestData;
use Lib\Http\Response;
use Lib\Http\RouteCollection;
use Lib\Http\Router;

try {
    $Router = new Router(RequestData::createFromGlobals(), RouteCollection::$routes);
    $Controller = $Router->getMatchingController();

    // Execute the request controller or return a 404 error if the route doesn't exists
    if (isset($Controller)) {
        $Response = $Router->execute($Controller);
    } else {
        $Response = Response::template(__DIR__.'/404.html', 404);
    }
} catch (\Exception $Exception) {
    if ($Exception instanceof MethodNotAllowedException) {
        $Response = Response::template(__DIR__.'/405.html', 405);
    } else {
        $Response = Response::template(__DIR__.'/500.html', 500);
    }
}

return $Response;
