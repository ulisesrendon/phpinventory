<?php

use App\Lib\Http\Router;
use App\Database\Migration\Migration;
use App\Lib\Http\DefaultController;
use App\Product\Controller\ProductController;

Router::any('/', [DefaultController::class, 'home']);
Router::post('/migrate', [Migration::class, 'start']);
Router::get('/product/:id', [ProductController::class, 'getById']);