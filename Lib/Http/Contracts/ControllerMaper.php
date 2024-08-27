<?php
namespace Lib\Http\Contracts;

use Lib\Http\Contracts\ControllerWrapper;

interface ControllerMaper
{
    public function setPath(string $path);

    public function getPath(): string;

    // public function setRegexp(): string;

    // public function getRegexp(): string;

    public function addController(string $method, ControllerWrapper $controller);

    public function getController(string $method): ?ControllerWrapper;

    public function pathMatches(string $path): bool;

    public function methodMatches(string $method): bool;
}