<?php

use Neuralpin\HTTPRouter\Router;
use Neuralpin\HTTPRouter\Response;
use App\Framework\HTTP\RouteMapper;
use App\Database\Migration\Migration;
use App\Order\Controller\OrderController;
use App\Product\Controller\StockController;
use App\Product\Controller\ProductController;
use App\Product\Controller\ProviderController;

$Router = new Router(ControllerMapper: RouteMapper::class);

// $Router->any('/', fn () => 'Hello world!');
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

$Router->get('/api/v1/order', [OrderController::class, 'list']);
$Router->post('/api/v1/order', [OrderController::class, 'create']);
$Router->get('/api/v1/order/:id', [OrderController::class, 'getById']);
$Router->patch('/api/v1/order/:id', [OrderController::class, 'update']);

$Router->get('/api/v1/stock', [StockController::class, 'list']);
$Router->get('/api/v1/stock/:id', [StockController::class, 'getByProductId']);
$Router->post('/api/v1/stock', [StockController::class, 'create']);
$Router->post('/api/v1/stock/:id/sync', [StockController::class, 'productStockSync']);
$Router->delete('/api/v1/stock', [StockController::class, 'delete']);

$Router->post('/api/v1/migrate', [Migration::class, 'start']);

$Router->get('/route-list', function() use($Router){
    $list = [];
    foreach($Router->RouteCollection->getRoutes() as $uri => $Route){
        foreach($Route->getControllerAll() as $method => $Controller){
            $list[] = "[$method] $uri";
        }
    }

    return Response::json($list);
});