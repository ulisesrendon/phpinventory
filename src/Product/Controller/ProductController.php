<?php

namespace App\Product\Controller;

use App\Product\DAO\ProductCommand;
use App\Product\DAO\ProductQuery;
use App\Product\Presentor\ProductOptionGrouping;
use App\Shared\Controller\DefaultController;
use Neuralpin\HTTPRouter\Response;
use Neuralpin\HTTPRouter\RequestData as Request;

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
        $ProductOptions = (new ProductOptionGrouping($this->ProductQuery->getById($id)))->get();
        $Product = $ProductOptions[$id] ?? null;

        if (is_null($Product)) {
            return Response::json([
                'id' => $id,
                'product' => [],
            ], 404);
        }

        return Response::json([
            'id' => $id,
            'product' => $Product,
        ]);

    }

    public function list()
    {
        $ProductData = $this->ProductQuery->list();
        $ProductList = (new ProductOptionGrouping($ProductData))->get();

        return Response::json([
            'count' => count($ProductList),
            'list' => array_values($ProductList),
        ]);
    }

    public function create(Request $Request)
    {
        $code = $Request->getInput('code');
        $title = $Request->getInput('title');
        $description = $Request->getInput('description') ?? '';
        $price = $Request->getInput('price') ?? 0;

        if (empty($code)) {
            return Response::json([
                'error' => 'Product code is required',
            ], 400);
        }

        if ($this->ProductQuery->codeExists($code)) {
            return Response::json([
                'error' => 'Product code already exists',
            ], 400);
        }

        if (empty($title)) {
            return Response::json([
                'error' => 'Product title is required',
            ], 400);
        }

        $result = $this->ProductCommand->create(
            code: $code,
            title: $title,
            description: $description,
            price: $price,
        );

        return Response::json([
            'status' => 'success',
            'id' => ! empty($result) ? (int) $result : null,
        ], 201);

    }

    public function update(int $id, Request $Request)
    {

        $code = $Request->getInput('code') ?? null;
        $title = $Request->getInput('title') ?? null;
        $description = $Request->getInput('description') ?? null;
        $price = $Request->getInput('price') ?? null;

        $OlderProductOptions = (new ProductOptionGrouping($this->ProductQuery->getById($id)))->get();
        $OlderProductData = $OlderProductOptions[$id] ?? null;

        if (empty($OlderProductData)) {
            return Response::json([
                'error' => 'Product not found',
            ], 404);
        }

        if (! is_null($code) && empty($code)) {
            return Response::json([
                'error' => 'Product code is required',
            ], 400);
        }

        if (
            ! empty($code)
            && $code != $OlderProductData->code
            && $this->ProductQuery->codeExists($code)
        ) {
            return Response::json([
                'error' => 'Product code already exists',
            ], 400);
        }

        if (! is_null($code) && empty($title)) {
            return Response::json([
                'error' => 'Product title is required',
            ], 400);
        }

        $fields = [
            'id' => $id,
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

        $result = $this->ProductCommand->update($fields);

        return Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);

    }

    public function delete(int $id)
    {
        $result = $this->ProductCommand->delete($id);

        return Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);
    }
}
