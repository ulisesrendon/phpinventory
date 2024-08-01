<?php

namespace Lib\Http;

class Router
{
    public static array $routes = [];

    public static array $methods = [
        'get',
        'post',
        'put',
        'patch',
        'delete',
        'options',
        'head',
    ];

    public static ?RequestData $RequestData = null;

    public static function addRoute(string $method, string $path, object|array $callable): Route
    {
        $Route = new Route(
            method: $method,
            path: $path,
            controller: $callable,
        );
        self::$routes[] = $Route;
        return $Route;
    }

    // [TODO] Improve method calling
    public static function get(string $path, object|array $callable)
    {
        self::addRoute('get', $path, $callable);
    }

    public static function post(string $path, object|array $callable)
    {
        self::addRoute('post', $path, $callable);
    }

    public static function put(string $path, object|array $callable)
    {
        self::addRoute('put', $path, $callable);
    }

    public static function patch(string $path, object|array $callable)
    {
        self::addRoute('patch', $path, $callable);
    }

    public static function delete(string $path, object|array $callable)
    {
        self::addRoute('delete', $path, $callable);
    }

    public static function options(string $path, object|array $callable)
    {
        self::addRoute('options', $path, $callable);
    }

    public static function head(string $path, object|array $callable)
    {
        self::addRoute('head', $path, $callable);
    }

    public static function any(string $path, object|array $callable)
    {
        self::addRoute('any', $path, $callable);
    }

    public static function route(RequestData $RequestData): bool
    {
        self::$RequestData = $RequestData;
        
        $methodNotAllowed = false;

        foreach (self::$routes as $Route) {

            $urlMatches = preg_match($Route->regexp, $RequestData->uri, $Params);
            $methodMatches = $Route->method === $RequestData->method || $Route->method === 'any';

            if ($urlMatches && $methodMatches) {
                array_shift($Params); // Remove the first match, which is the entire URL
                preg_match_all('/:([a-zA-Z0-9]+)/', $Route->path, $param_names);
                $Params = array_combine($param_names[1], $Params);

                return $Route->execute($RequestData, $Params);
            }

            if ($urlMatches) {
                $methodNotAllowed = true;
            }
        }

        if ($methodNotAllowed) {
            Response::html('', 405);
        }

        return false;
    }
}
