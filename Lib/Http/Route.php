<?php

namespace Lib\Http;

class Route
{
    public readonly string $path;

    public readonly string $regexp;

    public array $methods = [];

    public function __construct(
        string $path,
        string $method,
        object|array $controller,
    ) {
        $this->path = $path;
        $regexp = preg_replace('/:([a-zA-Z0-9]+)/', '([^/]+)', $path);
        $this->regexp = '/^'.str_replace('/', '\/', $regexp).'$/';
        $this->addController($method, $controller);
    }

    public function addController(string $method, object|array $controller)
    {
        $this->methods[strtolower($method)] = $controller;
    }

    public function urlMatches(string $url): bool
    {
        return preg_match($this->regexp, $url);
    }

    public function methodMatches(string $method): bool
    {
        return (isset($this->methods[$method]) || isset($this->methods['any'])) ? true : false;
    }

    public function bindParams(string $url): array
    {
        preg_match('/:([a-zA-Z0-9]+)/', $this->path, $paramNames);
        array_shift($paramNames);
        preg_match($this->regexp, $url, $uriParams);
        array_shift($uriParams);

        return array_combine($paramNames, $uriParams);
    }

    public function getController(string $method): null|array|object
    {
        return $this->methods[$method] ?? $this->methods['any'] ?? null;
    }
}
