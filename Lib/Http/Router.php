<?php

namespace Lib\Http;

use Stringable;
use Lib\Http\Route;
use Lib\Http\Helper\RequestData;
use Lib\Http\Contracts\RouteMaper;
use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\RouteMatcher;
use Lib\Http\Contracts\ControllerWrapper;
use Lib\Http\Exception\MethodNotAllowedException;


class Router implements RouteMatcher
{

    public function getController(RouteMaper $RouteMaper, RequestState $RequestState): ?ControllerWrapper
    {
        foreach ($RouteMaper->getRoutes() as $Route) {
            /* @var Route $Rute */
            $urlMatches = $Route->pathMatches($RequestState->getPath());
            $methodMatches = $Route->methodMatches($RequestState->getMethod());

            if ($urlMatches && !$methodMatches) {
                throw new MethodNotAllowedException('Method not allowed');
            }

            if ($urlMatches && $methodMatches) {
                return $Route->getController($RequestState);
            }
        }

        return null;
    }
}
