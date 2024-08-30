<?php

namespace App\Product\Controller;

use App\Product\DAO\StockCommand;
use App\Product\DAO\StockQuery;
use App\Shared\Controller\DefaultController;
use Lib\Http\Helper\RequestData;
use Lib\Http\Response;

class StockController extends DefaultController
{
    private readonly StockQuery $StockQuery;

    private readonly StockCommand $StockCommand;

    public function __construct()
    {
        parent::__construct();
        $this->StockQuery = new StockQuery($this->DataBaseAccess);
        $this->StockCommand = new StockCommand($this->DataBaseAccess);
    }

    public function list()
    {
        $List = $this->StockQuery->list();

        return Response::json([
            'count' => count($List),
            'list' => $List,
        ]);

    }

    public function getByProductId(int $id)
    {

        $ProductData = $this->StockQuery->getProductDataByID($id);
        $Entries = $this->StockQuery->getByProductID($id);

        if (is_null($ProductData)) {
            return Response::json([
                'error' => 'Product not found',
            ], 404);
        }

        return Response::json([
            'product' => $ProductData,
            'entries' => $Entries,
        ]);

    }

    public function create(RequestData $Request)
    {
        $stock = $Request->getInput('stock') ?? null;

        if (empty($stock) || gettype($stock) != 'array') {
            return Response::json([
                'error' => 'No product stock received',
            ], 400);
        }

        $TotalAdded = 0;
        foreach ($stock as $ProductStock) {

            if (
                ! isset($ProductStock['product_id'])
                || ! is_numeric($ProductStock['product_id'])
                || ! $this->StockQuery->productIdExists($ProductStock['product_id'])
            ) {
                continue;
            }

            if (
                ! isset($ProductStock['quantity']) || ! is_numeric($ProductStock['quantity'])
            ) {
                continue;
            }

            if (
                isset($ProductStock['provider_id']) && ! is_numeric($ProductStock['provider_id'])
            ) {
                continue;
            }

            if (
                isset($ProductStock['cost']) && ! is_numeric($ProductStock['cost'])
            ) {
                continue;
            }

            if (
                isset($ProductStock['lot']) && empty($ProductStock['lot'])
            ) {
                continue;
            }

            if (
                isset($ProductStock['expiration_date']) && strtotime($ProductStock['expiration_date'])
            ) {
                continue;
            }

            $this->StockCommand->create(
                product_id: $ProductStock['product_id'],
                quantity: $ProductStock['quantity'],
                provider_id: $ProductStock['provider_id'] ?? null,
                cost: $ProductStock['cost'] ?? null,
                lot: $ProductStock['lot'] ?? null,
                expiration_date: $ProductStock['expiration_date'] ?? null,
            );
            $TotalAdded++;
        }

        if ($TotalAdded != count($stock)) {
            return Response::json([
                'status' => 'success',
                'message' => 'Some data could not be saved due to data formatting issues',
            ], 201);
        }

        return Response::json([
            'status' => 'success',
            'message' => 'All data have been saved',
        ], 201);

    }

    public function delete(RequestData $Request)
    {
        $entries = $Request->getInput('entries') ?? null;

        if (! is_array($entries) || empty($entries)) {
            return Response::json([
                'error' => 'Invalid product data',
            ], 400);
        }

        foreach ($entries as $id) {
            if (! is_numeric($id) || empty($id)) {
                return Response::json([
                    'error' => 'Invalid product data',
                ], 400);
            }
        }

        foreach ($entries as $id) {
            $result = $this->StockCommand->deleteEntryById($id);
        }

        return Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);
    }

    public function productStockSync()
    {
        return Response::json('Hello!');
    }
}
