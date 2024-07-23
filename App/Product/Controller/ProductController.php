<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use Lib\Http\DefaultController;
use App\Product\Model\ProductModel;
use App\Product\Presentor\ProductOptionGrouping;

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

    public function list()
    {
        $ProductBaseList = (new ProductModel)->list();
        $ProductList = (new ProductOptionGrouping($ProductBaseList))->get();

        ApiResponse::json([
            'count' => count($ProductList),
            'list' => $ProductList,
        ]);

        return true;
    }
}