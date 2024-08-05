<?php

namespace App\Product\Controller;

use App\Product\DAO\ProductCommand;
use App\Product\DAO\ProductQuery;
use App\Product\Presentor\ProductOptionGrouping;
use Lib\Http\DefaultController;
use Lib\Http\Response;

class ProductController extends DefaultController
{
    private readonly ProductQuery $ProductQuery;

    private readonly ProductCommand $ProductCommand;

    public function __construct()
    {
        parent::__construct();
        $this->ProductQuery = new ProductQuery($this->DataBaseAccess);
        $this->ProductCommand = new ProductCommand($this->DataBaseAccess);
    }

    public function getById(int $id)
    {
        $ProductOptions = (new ProductOptionGrouping($this->ProductQuery->getByID($id)))->get();
        $Product = empty($ProductOptions) ? null : $ProductOptions[0];

        if (is_null($Product)) {
            Response::json([
                'id' => $id,
                'product' => [],
            ], 404);
        }

        Response::json([
            'id' => $id,
            'product' => $Product,
        ]);

        return true;
    }

    public function list()
    {
        $ProductList = (new ProductOptionGrouping($this->ProductQuery->list()))->get();

        Response::json([
            'count' => count($ProductList),
            'list' => $ProductList,
        ]);

        return true;
    }

    public function create()
    {
        $code = $this->Request->body['code'] ?? null;
        $title = $this->Request->body['title'] ?? null;
        $description = $this->Request->body['description'] ?? '';
        $price = $this->Request->body['price'] ?? 0;

        if (empty($code)) {
            Response::json([
                'error' => 'Product code is required',
            ], 400);
        }

        if ($this->ProductQuery->codeExists($code)) {
            Response::json([
                'error' => 'Product code already exists',
            ], 400);
        }

        if (empty($title)) {
            Response::json([
                'error' => 'Product title is required',
            ], 400);
        }

        $result = $this->ProductCommand->create(
            code: $code,
            title: $title,
            description: $description,
            price: $price,
        );

        Response::json([
            'status' => 'success',
            'id' => ! empty($result) ? (int) $result : null,
        ], 201);

        return true;
    }

    public function update(int $id)
    {

        $code = $this->Request->body['code'] ?? null;
        $title = $this->Request->body['title'] ?? null;
        $description = $this->Request->body['description'] ?? null;
        $price = $this->Request->body['price'] ?? null;

        $OlderProductOptions = (new ProductOptionGrouping($this->ProductQuery->getByID($id)))->get();
        $OlderProductData = empty($OlderProductOptions) ? null : $OlderProductOptions[0];

        if (empty($OlderProductData)) {
            Response::json([
                'error' => 'Product not found',
            ], 404);
        }

        if (! is_null($code) && empty($code)) {
            Response::json([
                'error' => 'Product code is required',
            ], 400);
        }

        if (
            ! empty($code)
            && $code != $OlderProductData->code
            && $this->ProductQuery->codeExists($code)
        ) {
            Response::json([
                'error' => 'Product code already exists',
            ], 400);
        }

        if (! is_null($code) && empty($title)) {
            Response::json([
                'error' => 'Product title is required',
            ], 400);
        }

        $fields = [
            'updated_at' => (new \DateTime)->format('Y-m-d H:i:s'),
        ];

        if (! is_null($code)) {
            $fields['code'] = (string) $code;
        }
        if (! is_null($title)) {
            $fields['title'] = (string) $title;
        }
        if (! is_null($description)) {
            $fields['description'] = (string) $description;
        }
        if (! is_null($price)) {
            $fields['price'] = (float) $price;
        }

        $result = $this->ProductCommand->update(
            id: $id,
            fields: $fields
        );

        Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }

    public function deleteById(int $id)
    {
        $result = $this->ProductCommand->deleteByID($id);

        Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }
}
