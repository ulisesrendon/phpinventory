<?php
namespace Lib\Http\Contracts;

use Lib\Http\Contracts\ControllerMaper;

interface RouteMaper
{
    /**
     * @return ControllerMaper[]
     */
    public function getRoutes(): array;
}