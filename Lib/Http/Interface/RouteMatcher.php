<?php

namespace Lib\Http\Interface;

interface RouteMatcher
{
    public function getController(RouteMaper $RouteMaper, RequestState $RequestState): ?ControllerWrapper;
}
