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

    public function create()
    {
        $ProductModel = new ProductModel();

        $code = $this->Request->body['code'] ?? null;
        $title = $this->Request->body['title'] ?? null;
        $description = $this->Request->body['description'] ?? '';
        $price = $this->Request->body['price'] ?? 0;

        if(empty($code)){
            ApiResponse::json([
                'error' => 'Product code is required',
            ], 400);
        }

        if ($ProductModel->codeExists($code)) {
            ApiResponse::json([
                'error' => 'Product code already exists',
            ], 400);
        }

        if(empty($title)){
            ApiResponse::json([
                'error' => 'Product title is required',
            ], 400);
        }

        $result = $ProductModel->create(
            code: $code,
            title: $title,
            description: $description,
            price: $price,
        );

        ApiResponse::json([
            'status' => 'success',
            'id' => !empty($result) ? (int) $result : null,
        ], 201);

        return true;
    }

    public function update(int $id)
    {
        $ProductModel = new ProductModel();

        $code = $this->Request->body['code'] ?? null;
        $title = $this->Request->body['title'] ?? null;
        $description = $this->Request->body['description'] ?? '';
        $price = $this->Request->body['price'] ?? 0;

        //[TODO]
        $OlderProductData = $ProductModel->getByID($id);

        if (empty($code)) {
            ApiResponse::json([
                'error' => 'Product code is required',
            ], 400);
        }

        if ($ProductModel->codeExists($code)) {
            ApiResponse::json([
                'error' => 'Product code already exists',
            ], 400);
        }

        if (empty($title)) {
            ApiResponse::json([
                'error' => 'Product title is required',
            ], 400);
        }

        $result = $ProductModel->update(
            id: $id,
            fields: [
                'code' => $code,
                'title' => $title,
                'description' => $description,
                'price' => $price,
            ]
        );

        ApiResponse::json([
            'status' => !empty($result) ? 'success' : 'something went wrong',
        ], 201);

        return true;
    }

    public function deleteById(int $id)
    {
        $ProductModel = new ProductModel();

        if(empty($id)){
            ApiResponse::json([
                'error' => 'Product identifier not provided',
            ], 400);
        }

        $result = $ProductModel->deleteByID($id);

        ApiResponse::json([
            'status' => !empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }
}