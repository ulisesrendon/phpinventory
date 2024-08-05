<?php

namespace Lib\Http;

use Lib\Http\RouteController;
use Lib\Http\MethodNotAllowedException;

class Router
{
    public static RequestData $RequestData;
    public array $Routes;
    public function __construct(
        RequestData $RequestData,
        array $Routes,
    )
    {
        self::$RequestData = $RequestData;
        $this->Routes = $Routes;
    }

    public function getMatchingController(): ?RouteController
    {

        foreach ($this->Routes as $Route) {

            $urlMatches = $Route->urlMatches(self::$RequestData->uri);
            $methodMatches = $Route->methodMatches(self::$RequestData->method);

            if ($urlMatches && !$methodMatches) {
                throw new MethodNotAllowedException('Method not allowed');
            }

            if ($urlMatches && $methodMatches) {
                $Controller = $Route->getController(self::$RequestData->method);
                $Params = $Route->bindParams(self::$RequestData->uri);
                return new RouteController($Controller, $Params);
            }
        }

        return null;
    }

    public function execute(RouteController $RouteController)
    {
        $Controller = $RouteController->Controller;
        if (is_array($Controller)) {
            [$class, $method] = $Controller;
            $Controller = [new $class(), $method];
        }

        call_user_func_array($Controller, $RouteController->Params);
    }
}
