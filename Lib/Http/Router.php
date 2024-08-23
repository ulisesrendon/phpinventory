<?php

namespace Lib\Http;

use Closure;
use Lib\Http\Helper\RequestData;
use Lib\Http\Exception\MethodNotAllowedException;
use Lib\Http\Exception\InvalidControllerException;

class Router
{
    public static RequestData $RequestData;

    public array $Routes;

    public function __construct(
        RequestData $RequestData,
        array $Routes,
    ) {
        self::$RequestData = $RequestData;
        $this->Routes = $Routes;
    }

    public function getMatchingController(): ?RouteController
    {

        foreach ($this->Routes as $Route) {

            $urlMatches = $Route->urlMatches(self::$RequestData->uri);
            $methodMatches = $Route->methodMatches(self::$RequestData->method);

            if ($urlMatches && ! $methodMatches) {
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

        if (
            is_array($Controller) && (!class_exists($Controller[0]) || !method_exists($Controller[0], $Controller[1]))
            || is_object($Controller) && !is_callable($Controller)
        ) {
            throw new InvalidControllerException('Route controller is not a valid callable or it can not be called from the actual scope');
        }

        if (is_array($Controller)) {
            [$class, $method] = $Controller;
            $Controller = [new $class, $method];
        }

        if ($Controller instanceof Closure) {
            ob_start();
            call_user_func_array($Controller, $RouteController->Params);
            $content = ob_get_clean();
            $controllerResponse = new TextRender($content);
        } else {
            $controllerResponse = call_user_func_array($Controller, $RouteController->Params);
        }

        return $controllerResponse;
    }
}
