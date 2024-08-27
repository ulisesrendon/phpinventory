<?php

namespace Lib\Http;

use Lib\Http\Exception\MethodNotAllowedException;
use Lib\Http\Helper\RequestData;
use Stringable;

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
                return $Route->getController(self::$RequestData);
            }
        }

        return null;
    }
}
