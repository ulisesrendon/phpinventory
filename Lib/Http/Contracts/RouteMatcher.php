<?php
namespace Lib\Http\Contracts;

use Lib\Http\Contracts\RouteMaper;
use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\ControllerWrapper;

interface RouteMatcher
{
    public function getController(RouteMaper $RouteMaper, RequestState $RequestState): ?ControllerWrapper;
}