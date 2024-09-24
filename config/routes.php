<?php

use App\Framework\Validator;
use App\Database\Migration\Migration;
use App\Product\Controller\StockController;
use App\Shared\Controller\DefaultController;
use Neuralpin\HTTPRouter\Helper\RequestData;
use App\Product\Controller\ProductController;
use App\Product\Controller\ProviderController;
use Neuralpin\HTTPRouter\RouteCollection as Routes;

Routes::any('/', fn () => 'Hello world!');
// Routes::any('/api/v1', [DefaultController::class, 'home']);
Routes::any('/api/v1', function(RequestData $Request){
    $test = $Request->getInput('test');

    $result = Validator::field($test)->required()->int()->max(10)->min(1)->isCorrect();
    $errors = Validator::field($test)->required()->int()->max(10)->min(1)->getErrors();
    
    $singleValidation = new Validator([
        'single' => [
            'value' => '1',
            'conditions' => [
                'int' => [],
            ],
        ]
    ]);


    dd($singleValidation);
});

Routes::post('/api/v1/product', [ProductController::class, 'create']);
Routes::get('/api/v1/product', [ProductController::class, 'list']);
Routes::get('/api/v1/product/:id', [ProductController::class, 'getById']);
Routes::patch('/api/v1/product/:id', [ProductController::class, 'update']);
Routes::delete('/api/v1/product/:id', [ProductController::class, 'delete']);

Routes::get('/api/v1/provider', [ProviderController::class, 'list']);
Routes::post('/api/v1/provider', [ProviderController::class, 'create']);
Routes::get('/api/v1/provider/:id', [ProviderController::class, 'getById']);
Routes::patch('/api/v1/provider/:id', [ProviderController::class, 'update']);
Routes::delete('/api/v1/provider/:id', [ProviderController::class, 'delete']);

Routes::get('/api/v1/stock', [StockController::class, 'list']);
Routes::get('/api/v1/stock/:id', [StockController::class, 'getByProductId']);
Routes::post('/api/v1/stock', [StockController::class, 'create']);
Routes::post('/api/v1/stock/:id/sync', [StockController::class, 'productStockSync']);
Routes::delete('/api/v1/stock', [StockController::class, 'delete']);

Routes::any('/api/v1/ping', fn () => 'pong');
Routes::post('/api/v1/migrate', [Migration::class, 'start']);
Routes::get('/api/v1/search/:search', function ($search) {
    $search = explode('/', htmlspecialchars($search));
    $search = implode(' ', $search);

    return "Searching: $search";
})->ignoreParamSlash();
