<?php

require __DIR__.'/../Config/routes.php';

use Lib\Http\Router;
use Lib\Http\Response;
use Lib\Http\RouteCollection;
use Lib\Http\Helper\RequestData;
use Lib\Http\Exception\NotFoundException;
use Lib\Http\Exception\MethodNotAllowedException;

$_ENV['APP_DEBUG'] ??= 0;

try {
    $Router = new Router(RequestData::createFromGlobals(), RouteCollection::$routes);
    $Controller = $Router->getMatchingController();

    // Throw 404 server error if route doesn't exists
    if (is_null($Controller)) {
        throw new NotFoundException();
    }
} catch (\Exception $Exception) {
    if ($Exception instanceof NotFoundException) {
        $Controller = Response::template(__DIR__.'/../public/404.html', 404);
    } else if ($Exception instanceof MethodNotAllowedException) {
        $Controller = Response::template(__DIR__.'/../public/405.html', 405);
    } else if($_ENV['APP_DEBUG'] == 0) {
        $Controller = Response::template(__DIR__.'/../public/500.html', 500);
    } else{
        $Controller = Response::html($Exception, 500);
    }
}

return (string) $Controller;
