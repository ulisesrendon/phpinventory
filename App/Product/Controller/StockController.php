<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use Lib\Http\DefaultController;
use App\Product\Model\ProductModel;

class StockController extends DefaultController
{
    public function getById(int $id)
    {
        $Product = (new ProductModel)->getByID($id);

        if (empty($Product)) {
            ApiResponse::json([
                'id' => $id,
                'product' => $Product,
            ], 404);
        }

        ApiResponse::json([
            'id' => $id,
            'product' => $Product,
        ]);

        return true;
    }
}