<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use Lib\Http\RequestData;
use App\Product\DAO\StockQuery;
use Lib\Http\DefaultController;
use App\Product\DAO\StockCommand;

class StockController extends DefaultController
{
    private readonly StockQuery $StockQuery;
    private readonly StockCommand $StockCommand;
    public function __construct(public RequestData $Request)
    {
        parent::__construct($Request);
        $this->StockQuery = new StockQuery($this->DataBaseAccess);
        $this->StockCommand = new StockCommand($this->DataBaseAccess);
    }

    public function list()
    {
        $List = $this->StockQuery->list();

        ApiResponse::json([
            'count' => count($List),
            'list' => $List,
        ]);

        return true;
    }

    public function getByProductId(int $id)
    {

        $ProductData = $this->StockQuery->getProductDataByID($id);
        $Entries = $this->StockQuery->getByProductID($id);

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
        $stock = $this->Request->body['stock'] ?? null;

        if(empty($stock) || gettype($stock) != 'array'){
            ApiResponse::json([
                'error' => 'No product stock received',
            ], 400);
        }

        $TotalAdded = 0;
        foreach($stock as $ProductStock){

            if(
                !isset($ProductStock['product_id']) 
                || !is_numeric($ProductStock['product_id'])
                || !$this->StockQuery->productIdExists($ProductStock['product_id'])
            ){
                continue;
            }

            if(
                !isset($ProductStock['quantity']) || !is_numeric($ProductStock['quantity'])
            ){
                continue;
            }

            if(
                isset($ProductStock['provider_id']) && !is_numeric($ProductStock['provider_id'])
            ){
                continue;
            }

            if(
                isset($ProductStock['cost']) && !is_numeric($ProductStock['cost'])
            ){
                continue;
            }

            if(
                isset($ProductStock['lot']) && empty($ProductStock['lot'])
            ){
                continue;
            }

            if(
                isset($ProductStock['expiration_date']) && strtotime($ProductStock['expiration_date'])
            ){
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

        if($TotalAdded != count($stock)){
            ApiResponse::json([
                'status' => 'success',
                'message' => 'Some data could not be saved due to data formatting issues',
            ], 201);
        }

        ApiResponse::json([
            'status' => 'success',
            'message' => 'All data have been saved',
        ], 201);

        return true;
    }

    public function delete()
    {
        $entries = $this->Request->body['entries'] ?? null;

        if (!is_array($entries) || empty($entries)) {
            ApiResponse::json([
                'error' => 'Invalid product data'
            ], 400);
        }

        foreach($entries as $id){
            if (!is_numeric($id) || empty($id)) {
                ApiResponse::json([
                    'error' => 'Invalid product data'
                ], 400);
            }
        }

        foreach($entries as $id){
            $result = $this->StockCommand->deleteEntryById($id);
        }

        ApiResponse::json([
            'status' => !empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }

    public function productStockSync()
    {
        ApiResponse::json('Hello!');

        return true;
    }
}