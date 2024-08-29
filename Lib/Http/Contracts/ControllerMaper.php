<?php
namespace Lib\Http\Contracts;

use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\ControllerWrapper;

interface ControllerMaper
{
    public function addController(string $method, ControllerWrapper $controller);

    public function getController(RequestState $RequestState): ?ControllerWrapper;

    public function pathMatches(string $path): bool;

    public function methodMatches(string $method): bool;
}