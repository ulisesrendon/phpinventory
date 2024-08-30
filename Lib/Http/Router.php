<?php

namespace Lib\Http;

use Lib\Http\Exception\MethodNotAllowedException;
use Lib\Http\Interface\ControllerWrapper;
use Lib\Http\Interface\RequestState;
use Lib\Http\Interface\RouteMaper;
use Lib\Http\Interface\RouteMatcher;

class Router implements RouteMatcher
{
    public function getController(RouteMaper $RouteMaper, RequestState $RequestState): ?ControllerWrapper
    {
        foreach ($RouteMaper->getRoutes() as $Route) {
            $urlMatches = $Route->pathMatches($RequestState->getPath());
            $methodMatches = $Route->methodMatches($RequestState->getMethod());

            if ($urlMatches && ! $methodMatches) {
                throw new MethodNotAllowedException('Method not allowed');
            }

            if ($urlMatches && $methodMatches) {
                return $Route->getController($RequestState);
            }
        }

        return null;
    }
}
