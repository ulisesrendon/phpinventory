<?php

namespace Lib\Http;

class RouteCollection
{
    public static array $routes = [];

    public static function addRoute(string $method, string $path, object|array $callable): Route
    {
        if (isset(self::$routes[$path])) {
            $Route = self::$routes[$path];

            $Route->addController($method, $callable);
        } else {
            $Route = new Route(
                method: $method,
                path: $path,
                controller: $callable,
            );
            self::$routes[$path] = $Route;
        }

        return $Route;
    }

    public static function any(string $path, object|array $callable)
    {
        self::addRoute('any', $path, $callable);
    }

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

    /*
    * To avoid defining each of the http add methods, this code would make the job
    */
    // public static array $methods = [
    //     'any',
    //     'get',
    //     'post',
    //     'put',
    //     'patch',
    //     'delete',
    //     'options',
    //     'head',
    // ];
    // public static function __callStatic(string $method, array $arguments): mixed
    // {
    //     $method = strtolower($method);

    //     $methodExists = array_search($method, self::$methods);
    //     if (!is_numeric($methodExists)) {
    //         throw new \Exception('The method: \'' . $method . '\' is not supported.');
    //     }
    //     return self::addRoute($method, ...$arguments);
    // }
}
