<?php

namespace Lib\Http;

use Lib\Http\RequestData;

class Router
{
    // [TODO] Improve controller collection
    public static array $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'patch' => [],
        'delete' => [],
        'options' => [],
        'head' => [],
    ];

    public static function addRoute(string $method, string $path, object|array $callable): void
    {
        self::$routes[$method][$path] = $callable;
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
        foreach(self::$routes as $method => $route){
            self::addRoute($method, $path, $callable);
        }
    }

    public static function route(RequestData $RequestData): bool
    {
        if(!isset(self::$routes[strtolower($RequestData->method)])){
            return false;
        }

        foreach (self::$routes[strtolower($RequestData->method)] as $routeUrl => $controller) {
            $urlFound = false;
            $urlHasParams = false;

            // Check if the route URL contains parameters
            if (strpos($routeUrl, ':') !== false) {
                $routeRegex = preg_replace('/:([a-zA-Z0-9]+)/', '([^/]+)', $routeUrl);
                $routeRegex = '/^' . str_replace('/', '\/', $routeRegex) . '$/';

                if (preg_match($routeRegex, $RequestData->uri, $Params)) {
                    // Remove the first match, which is the entire URL
                    array_shift($Params);
                    preg_match_all('/:([a-zA-Z0-9]+)/', $routeUrl, $param_names);
                    $Params = array_combine($param_names[1], $Params);

                    $urlFound = true;
                    $urlHasParams = true;
                }
            } else {
                // If the route URL does not contain parameters, compare it directly to the URL
                if ($RequestData->uri === $routeUrl) {
                    $urlFound = true;
                }
            }

            // [TODO] Improve controller validation
            if ($urlFound && is_array($controller)) {
                $controller = [new $controller[0]($RequestData), $controller[1]];
            }

            if($urlFound && !$urlHasParams){
                return call_user_func($controller);
            }else if($urlFound && $urlHasParams){
                return call_user_func_array($controller, $Params);
            }
        }

        return false;
    }
}