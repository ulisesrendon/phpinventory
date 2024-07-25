<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use Lib\Http\DefaultController;
use App\Product\Model\ProductDAO;

class ProviderController extends DefaultController
{
    public function getById(int $id)
    {
        // $Product = (new ProductDAO)->getByID($id);

        // if (empty($Product)) {
        //     ApiResponse::json([
        //         'id' => $id,
        //         'product' => $Product,
        //     ], 404);
        // }

        // ApiResponse::json([
        //     'id' => $id,
        //     'product' => $Product,
        // ]);

        ApiResponse::json('Hello!');

        return true;
    }
}