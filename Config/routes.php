<?php

use Lib\Http\Router;
use Lib\Http\DefaultController;
use App\Database\Migration\Migration;
use App\Product\Controller\StockController;
use App\Product\Controller\ProductController;
use App\Product\Controller\ProviderController;

Router::any('/', [DefaultController::class, 'home']);
Router::post('/migrate', [Migration::class, 'start']);

Router::post('/product', [ProductController::class, 'create']);
Router::get('/product', [ProductController::class, 'list']);
Router::get('/product/:id', [ProductController::class, 'getById']);
Router::patch('/product/:id', [ProductController::class, 'update']);
Router::delete('/product/:id', [ProductController::class, 'deleteById']);

Router::get('/provider', [ProviderController::class, 'list']);
Router::post('/provider', [ProviderController::class, 'create']);
Router::get('/provider/:id', [ProviderController::class, 'getById']);
Router::patch('/provider/:id', [ProviderController::class, 'update']);
Router::delete('/provider/:id', [ProviderController::class, 'delete']);

Router::get('/stock', [StockController::class, 'list']);
Router::get('/stock/:id', [StockController::class, 'getByProductId']);
Router::post('/stock', [StockController::class, 'create']);
Router::post('/stock/:id/sync', [StockController::class, 'productStockSync']);
Router::delete('/stock/:id', [StockController::class, 'delete']);