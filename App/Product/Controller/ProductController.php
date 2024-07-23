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
        $ProductList = (new ProductOptionGrouping($Product))->get();

        if(empty($Product)){
            ApiResponse::json([
                'id' => $id,
                'product' => [],
            ], 404);
        }

        ApiResponse::json([
            'id' => $id,
            'product' => $ProductList[0],
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