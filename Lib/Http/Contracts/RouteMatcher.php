<?php
namespace Lib\Http\Contracts;

use Lib\Http\Contracts\RouteMaper;
use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\RequestHandler;

interface RouteMatcher
{
    public function getHandler(RouteMaper $RouteMaper, RequestState $RequestState): RequestHandler;

    // bindparams
}