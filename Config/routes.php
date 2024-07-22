<?php

use Lib\Http\Router;
use Lib\Http\DefaultController;
use App\Database\Migration\Migration;
use App\Product\Controller\ProductController;

Router::any('/', [DefaultController::class, 'home']);
Router::post('/migrate', [Migration::class, 'start']);
Router::get('/product/:id', [ProductController::class, 'getById']);