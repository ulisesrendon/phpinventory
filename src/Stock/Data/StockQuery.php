<?php

namespace Stradow\Stock\Data;

use Stradow\Framework\Database\DataBaseAccess;

class StockQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getByProductID(int $id): ?array
    {
        return $this->DataBaseAccess->query('SELECT 
                products.id as product_id,
                entries_products.id as stock_id,
                entrylines.id as entry_id,
                entrylines.lot,
                entrylines.pieces,
                entries_products.stock,
                products.price as base_price,
                entries_products.price as price_alternative,
                entries.provider_id,
                providers.title as provider_title,
                entries.created_at
            from entries_products
            left join products on products.id = entries_products.product_id
            left join entrylines on entries_products.product_entry_id = entrylines.id
            left join entries on entries.id = entrylines.entry_id
            left join providers on providers.id = entries.provider_id
            where entries_products.product_id = :id
            order by entries.created_at desc
        ', ['id' => $id]);
    }

    public function getProductDataByID(int $id): ?object
    {
        return $this->DataBaseAccess->select('SELECT 
                products.id, 
                products.code,
                products.title,
                COALESCE(sum(entries_products.stock), 0) as stock
            from products
            left join entries_products on entries_products.product_id = products.id
            where products.deleted_at is null and products.id = :id
            group by 
                products.id, 
                products.code,
                products.title
        ', ['id' => $id]);
    }

    public function productIdExists(int $id): ?bool
    {
        return $this->DataBaseAccess->scalar('SELECT exists(
            SELECT id from products where id = :id
        )', ['id' => $id]);
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->query('SELECT 
                products.id, 
                products.code,
                products.title,
                COALESCE(sum(entries_products.stock), 0) as stock
            from products
            left join entries_products on entries_products.product_id = products.id
            where products.deleted_at is null
            group by 
                products.id, 
                products.code,
                products.title
            order by products.title
        ');
    }
}
