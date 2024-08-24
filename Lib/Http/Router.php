<?php

namespace Lib\Http;

use Stringable;
use Lib\Http\PreparedRoute;
use Lib\Http\Helper\RequestData;
use Lib\Http\Exception\MethodNotAllowedException;

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

    public function getMatchingController(): ?Stringable
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

                return new PreparedRoute($Controller, $Params);
            }
        }

        return null;
    }
}
