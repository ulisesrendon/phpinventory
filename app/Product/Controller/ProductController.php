<?php

namespace App\Product\Controller;

use App\Lib\Http\ApiResponse;
use App\Product\Model\ProductModel;
use App\Lib\Http\DefaultController;

class ProductController extends DefaultController
{
    public function getById(int $id)
    {
        $Product = (new ProductModel)->getByID($id);

        if(empty($Product)){
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