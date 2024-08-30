<?php

namespace Lib\Http\Interface;

interface RouteMaper
{
    /**
     * @return ControllerMaper[]
     */
    public function getRoutes(): array;
}
