<?php

namespace Lib\Http;

use Lib\Http\Contracts\ControllerWrapper;
use Lib\Http\Contracts\RequestState;
use Lib\Http\ControllerWrapped;
use Lib\Http\Contracts\ControllerMaper;

class Route implements ControllerMaper
{
    public readonly string $path;

    public readonly string $regexp;

    public readonly array $methods = [];

    public function __construct(
        string $path,
        ?string $method = null,
        null|object|array $controller = null,
    ) {
        $this->path = $path;
        $regexp = preg_replace('/:([a-zA-Z0-9]+)/', '([^/]+)', $path);
        $this->regexp = '/^'.str_replace('/', '\/', $regexp).'$/';

        if (isset($method, $controller)) {
            $this->addController($method, $controller);
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function addController(string $method, object|array $controller)
    {
        $this->methods[strtolower($method)] = $controller;

        return $this;
    }

    public function pathMatches(string $path): bool
    {
        return preg_match($this->regexp, $path);
    }

    public function methodMatches(string $method): bool
    {
        return (isset($this->methods[$method]) || isset($this->methods['any'])) ? true : false;
    }

    public function ignoreParamSlash()
    {
        $regexp = preg_replace('/:(.*)/', '(.*)', $this->path);
        $this->regexp = '/^'.str_replace('/', '\/', $regexp).'$/';

        return $this;
    }


    public function getController(RequestState $RequestData): ControllerWrapper
    {

        $Controller = $this->methods[$RequestData->getMethod()] ?? $this->methods['any'] ?? null;

        return new ControllerWrapped($Controller, $RequestData);
    }
}
