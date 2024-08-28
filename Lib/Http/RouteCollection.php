<?php

namespace Lib\Http;
use Lib\Http\Route;
use Lib\Http\Contracts\RouteMaper;
use Lib\Http\Contracts\ControllerMaper;

class RouteCollection implements RouteMaper
{
    
    public function getRoutes(): array
    {
        return self::$routes;
    }


    /**
     * @var ControllerMaper[] $routes
     */
    public static array $routes = [];

    public static function addRoute(string $method, string $path, object|array $callable): ControllerMaper
    {
        self::$routes[$path] ??= new Route($path);
        self::$routes[$path]->addController($method, $callable);

        return self::$routes[$path];
    }

    public static function any(string $path, object|array $callable)
    {
        return self::addRoute('any', $path, $callable);
    }

    public static function get(string $path, object|array $callable)
    {
        return self::addRoute('get', $path, $callable);
    }

    public static function post(string $path, object|array $callable)
    {
        return self::addRoute('post', $path, $callable);
    }

    public static function put(string $path, object|array $callable)
    {
        return self::addRoute('put', $path, $callable);
    }

    public static function patch(string $path, object|array $callable)
    {
        return self::addRoute('patch', $path, $callable);
    }

    public static function delete(string $path, object|array $callable)
    {
        return self::addRoute('delete', $path, $callable);
    }

    public static function options(string $path, object|array $callable)
    {
        return self::addRoute('options', $path, $callable);
    }

    public static function head(string $path, object|array $callable)
    {
        return self::addRoute('head', $path, $callable);
    }
}
