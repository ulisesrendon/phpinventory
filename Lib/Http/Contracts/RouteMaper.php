<?php
namespace Lib\Http\Contracts;

use Lib\Http\Contracts\ControllerMaper;
use Lib\Http\Contracts\ControllerWrapper;

interface RouteMaper
{
    public function addRoute(string $method, string $path, ControllerWrapper $controller): ControllerMaper;

    public function getRoutes(): array;
}