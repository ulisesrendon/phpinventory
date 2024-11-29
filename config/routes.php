<?php

use Neuralpin\HTTPRouter\Router;
use Neuralpin\HTTPRouter\Response;
use Stradow\Framework\HTTP\RouteMapper;
use Stradow\Order\Controller\OrderController;
use Stradow\Stock\Controller\StockController;
use Stradow\Content\Controller\ContentController;
use Stradow\Stock\Controller\ProviderController;
use Stradow\Product\Controller\ProductController;

$Router = new Router(ControllerMapper: RouteMapper::class);
$Router->get('/', fn()=> '-Stradow says: ✋ Hello world!');
$Router->post('/api/v1/product', [ProductController::class, 'create']);
$Router->get('/api/v1/product', [ProductController::class, 'list']);
$Router->get('/api/v1/product/:id', [ProductController::class, 'getById']);
$Router->patch('/api/v1/product/:id', [ProductController::class, 'update']);
$Router->delete('/api/v1/product/:id', [ProductController::class, 'delete']);

$Router->get('/api/v1/provider', [ProviderController::class, 'list']);
$Router->post('/api/v1/provider', [ProviderController::class, 'create']);
$Router->get('/api/v1/provider/:id', [ProviderController::class, 'getById']);
$Router->patch('/api/v1/provider/:id', [ProviderController::class, 'update']);
$Router->delete('/api/v1/provider/:id', [ProviderController::class, 'delete']);

$Router->get('/api/v1/stock', [StockController::class, 'list']);
$Router->get('/api/v1/stock/:id', [StockController::class, 'getByProductId']);
$Router->post('/api/v1/stock', [StockController::class, 'create']);
$Router->post('/api/v1/stock/:id/sync', [StockController::class, 'productStockSync']);
$Router->delete('/api/v1/stock', [StockController::class, 'delete']);

$Router->get('/api/v1/order', [OrderController::class, 'list']);
$Router->post('/api/v1/order', [OrderController::class, 'create']);
$Router->get('/api/v1/order/:id', [OrderController::class, 'getById']);
// $Router->patch('/api/v1/order/:id', [OrderController::class, 'update']);

$Router->get('/api/v1/content/field', [ContentController::class, 'fieldList']);
$Router->get('/api/v1/content/type', [ContentController::class, 'typeList']);

$Router->get('/api/v1/content', [ContentController::class, 'list']);
$Router->get('/api/v1/content/:id', [ContentController::class, 'find']);

$Router->get('/api/v1/route-list', function () use ($Router) {
    $list = [];
    foreach ($Router->RouteCollection->getRoutes() as $uri => $Route) {
        foreach ($Route->getControllerAll() as $method => $Controller) {
            $list[] = "[$method] $uri";
        }
    }

    return Response::json($list);
});

return $Router;
