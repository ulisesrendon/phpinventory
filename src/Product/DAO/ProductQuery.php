<?php

namespace App\Product\DAO;

use App\Framework\Database\DataBaseAccess;

class ProductQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getProductQuery(string $condition = ''): string
    {
        return "SELECT 
                products.id, 
                products.code,
                products.title,
                products.description,
                products.updated_at,
                products.price,
                product_stocks.stock,
                product_stocks.price as price_alt,
                product_stocks.product_entry_id as entry_id
            from products
            left join product_stocks on product_stocks.product_id = products.id
            where deleted_at is null $condition";
    }

    public function getById(int $id): ?array
    {
        return $this->DataBaseAccess->query($this->getProductQuery('and products.id = :id'), ['id' => $id]);
    }

    public function codeExists(string $code): ?bool
    {
        return $this->DataBaseAccess->scalar('SELECT exists(
            SELECT products.code from products where products.code = :code
        )', ['code' => $code]);
    }

    public function list(?array $ids = null): ?array
    {
        $idCondition = '';
        $params = [];
        if(!empty($ids)){
            foreach($ids AS $id){
                $params["id_$id"] = $id;
            }
            $markers = implode(',:', array_keys($params));
            $idCondition = "and products.id in (:$markers) ";
        }

        return $this->DataBaseAccess->query(
            $this->getProductQuery($idCondition . 'order by products.title'),
            $params
        );
    }
}
