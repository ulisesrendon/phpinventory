<?php

require __DIR__.'/routes.php';

use Neuralpin\HTTPRouter\Response;

$_ENV['APP_DEBUG'] ??= 0;

try {

    $Controller = $Router->getController();

} catch (\Exception $Exception) {
    if ($Router->isNotFoundException($Exception)) {
        $Controller = $Router->wrapController(
            fn () => Response::template(__DIR__.'/../public/404.html', 404),
        );
    } elseif ($Router->isMethodNotAllowedException($Exception)) {
        $Controller = $Router->wrapController(
            fn () => Response::template(__DIR__.'/../public/405.html', 405),
        );
    } else {
        if ($_ENV['APP_DEBUG'] != 0) {
            $Controller = $Router->wrapController(
                fn () => Response::html($Exception, 500),
            );
        } else {
            $Controller = $Router->wrapController(
                fn () => Response::template(__DIR__.'/../public/500.html', 500),
            );
        }
    }
}

return $Controller;
