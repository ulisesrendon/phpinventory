<?php

require __DIR__.'/routes.php';

use Neuralpin\HTTPRouter\ControllerWrapped;
use Neuralpin\HTTPRouter\Exception\MethodNotAllowedException;
use Neuralpin\HTTPRouter\Exception\NotFoundException;
use Neuralpin\HTTPRouter\Helper\RequestData;
use Neuralpin\HTTPRouter\Response;
use Neuralpin\HTTPRouter\RouteCollection;
use Neuralpin\HTTPRouter\Router;

$_ENV['APP_DEBUG'] ??= 0;

$Router = new Router;
$RouteCollection = new RouteCollection;
$RequestState = RequestData::createFromGlobals();

try {

    $Controller = $Router->getController($RouteCollection, $RequestState);

    if (is_null($Controller)) {
        throw new NotFoundException; // Throws 404 error when route doesn't exists
    }

} catch (\Exception $Exception) {
    if ($Exception instanceof NotFoundException) {
        $Controller = new ControllerWrapped(
            fn () => Response::template(__DIR__.'/../public/404.html', 404),
            $RequestState,
        );
    } elseif ($Exception instanceof MethodNotAllowedException) {
        $Controller = new ControllerWrapped(
            fn () => Response::template(__DIR__.'/../public/405.html', 405),
            $RequestState,
        );
    } else {
        if ($_ENV['APP_DEBUG'] != 0) {
            $Controller = new ControllerWrapped(
                fn () => Response::html($Exception, 500),
                $RequestState,
            );
        } else {
            $Controller = new ControllerWrapped(
                fn () => Response::template(__DIR__.'/../public/500.html', 500),
                $RequestState,
            );
        }
    }
}

return $Controller;
