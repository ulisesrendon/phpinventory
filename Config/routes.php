<?php

use Lib\Http\Router;
use Lib\Http\DefaultController;
use App\Database\Migration\Migration;
use App\Product\Controller\StockController;
use App\Product\Controller\ProductController;
use App\Product\Controller\ProviderController;

Router::any('/api/v1', [DefaultController::class, 'home']);
Router::post('/api/v1/migrate', [Migration::class, 'start']);

Router::post('/api/v1/product', [ProductController::class, 'create']);
Router::get('/api/v1/product', [ProductController::class, 'list']);
Router::get('/api/v1/product/:id', [ProductController::class, 'getById']);
Router::patch('/api/v1/product/:id', [ProductController::class, 'update']);
Router::delete('/api/v1/product/:id', [ProductController::class, 'deleteById']);

Router::get('/api/v1/provider', [ProviderController::class, 'list']);
Router::post('/api/v1/provider', [ProviderController::class, 'create']);
Router::get('/api/v1/provider/:id', [ProviderController::class, 'getById']);
Router::patch('/api/v1/provider/:id', [ProviderController::class, 'update']);
Router::delete('/api/v1/provider/:id', [ProviderController::class, 'delete']);

Router::get('/api/v1/stock', [StockController::class, 'list']);
Router::get('/api/v1/stock/:id', [StockController::class, 'getByProductId']);
Router::post('/api/v1/stock', [StockController::class, 'create']);
Router::post('/api/v1/stock/:id/sync', [StockController::class, 'productStockSync']);
Router::delete('/api/v1/stock', [StockController::class, 'delete']);