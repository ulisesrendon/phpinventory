<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use App\Product\DAO\StockDAO;
use Lib\Http\DefaultController;
use App\Product\Presentor\ProductOptionGrouping;

class StockController extends DefaultController
{
    public function list()
    {
        $List = (new StockDAO)->list();

        ApiResponse::json([
            'count' => count($List),
            'list' => $List,
        ]);

        return true;
    }

    public function getByProductId(int $id)
    {

        $ProductData = (new StockDAO)->getProductDataByID($id);
        $Entries = (new StockDAO)->getByProductID($id);

        if (is_null($ProductData)) {
            ApiResponse::json([
                'error' => 'Product not found',
            ], 404);
        }

        ApiResponse::json([
            'product' => $ProductData,
            'entries' => $Entries,
        ]);

        return true;
    }

    public function create()
    {
        // $code = $this->Request->body['code'] ?? null;

        // $StockDAO = new StockDAO();

        // $result = $StockDAO->create(
        //     code: $code,
        //     title: $title,
        //     description: $description,
        //     price: $price,
        // );

        // ApiResponse::json([
        //     'status' => 'success',
        //     'id' => !empty($result) ? (int) $result : null,
        // ], 201);

        return true;
    }

    public function delete()
    {
        ApiResponse::json('Hello!');

        return true;
    }

    public function productStockSync()
    {
        ApiResponse::json('Hello!');

        return true;
    }
}