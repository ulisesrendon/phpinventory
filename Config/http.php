<?php

require __DIR__.'/../Config/routes.php';

use Lib\Http\Exception\MethodNotAllowedException;
use Lib\Http\Exception\NotFoundException;
use Lib\Http\Helper\RequestData;
use Lib\Http\Response;
use Lib\Http\RouteCollection;
use Lib\Http\Router;

$_ENV['APP_DEBUG'] ??= 0;

try {
    $Router = new Router();
    $RouteCollection = new RouteCollection();
    $RequestData = RequestData::createFromGlobals();
    $Controller = $Router->getController($RouteCollection, $RequestData);

    // Throw 404 server error if route doesn't exists
    if (is_null($Controller)) {
        throw new NotFoundException;
    }
} catch (\Exception $Exception) {
    if ($Exception instanceof NotFoundException) {
        $Controller = Response::template(__DIR__.'/../public/404.html', 404);
    } elseif ($Exception instanceof MethodNotAllowedException) {
        $Controller = Response::template(__DIR__.'/../public/405.html', 405);
    } else {
        $Controller = $_ENV['APP_DEBUG'] == 0 ? Response::html($Exception, 500) : Response::template(__DIR__.'/../public/500.html', 500);
    }
}

return (string) $Controller;
