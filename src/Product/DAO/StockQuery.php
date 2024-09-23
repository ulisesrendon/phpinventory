<?php

namespace App\Product\DAO;

use App\Shared\Database\DataBaseAccess;

class StockQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getByProductID(int $id): ?array
    {
        return $this->DataBaseAccess->fetchQuery('SELECT 
                products.id as product_id,
                product_stocks.id as stock_id,
                product_entries.id as entry_id,
                product_entries.lot,
                product_entries.quantity,
                product_stocks.stock,
                products.price as base_price,
                product_stocks.price as price_alt,
                product_entries.provider_id,
                providers.title as provider_title,
                product_entries.created_at
            from product_stocks
            left join products on products.id = product_stocks.product_id
            left join product_entries on product_stocks.product_entry_id = product_entries.id
            left join providers on providers.id = product_entries.provider_id
            where product_stocks.product_id = :id
            order by product_entries.created_at desc
        ', ['id' => $id]);
    }

    public function getProductDataByID(int $id): ?object
    {
        return $this->DataBaseAccess->fetchFirst('SELECT 
                products.id, 
                products.code,
                products.title,
                COALESCE(sum(product_stocks.stock), 0) as stock
            from products
            left join product_stocks on product_stocks.product_id = products.id
            where products.deleted_at is null and products.id = :id
            group by 
                products.id, 
                products.code,
                products.title
        ', ['id' => $id]);
    }

    public function productIdExists(int $id): ?bool
    {
        return $this->DataBaseAccess->fetchScalar('SELECT exists(
            SELECT id from products where id = :id
        )', ['id' => $id]);
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->fetchQuery('SELECT 
                products.id, 
                products.code,
                products.title,
                COALESCE(sum(product_stocks.stock), 0) as stock
            from products
            left join product_stocks on product_stocks.product_id = products.id
            where products.deleted_at is null
            group by 
                products.id, 
                products.code,
                products.title
            order by products.title
        ');
    }
}
