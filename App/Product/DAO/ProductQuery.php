<?php

namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

class ProductQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getByID(int $id): ?array
    {
        return $this->DataBaseAccess->fetchQuery('SELECT 
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
            where deleted_at is null and products.id = :id
        ', ['id' => $id]);
    }

    public function codeExists(string $code): ?bool
    {
        return $this->DataBaseAccess->fetchScalar('SELECT exists(
            SELECT products.code from products where products.code = :code
        )', ['code' => $code]);
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->fetchQuery('SELECT 
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
            where deleted_at is null
            order by products.title
        ');
    }
}
