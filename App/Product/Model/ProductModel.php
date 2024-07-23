<?php
namespace App\Product\Model;

use Lib\Database\DBAccess;
use Lib\Database\DefaultModel;

class ProductModel extends DefaultModel
{

    public function create(array $data)
    {
        return $this->DBA->executeCommand("INSERT INTO products(
                title,
                description
            ) VALUES(
                :title,
                :description
            )", $data);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DBA->executeCommand("DELETE FROM products WHERE id = '$id'");
    }

    public function get()
    {
        return $this->DBA->fetchQuery('SELECT * FROM products');
    }

    public function getByID(int $id)
    {
        return $this->DBA->fetchFirst("SELECT 
            * 
            FROM products WHERE id = '$id'
        ");
    }

    public function list()
    {
        return $this->DBA->fetchQuery("SELECT 
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
        ");
    }
}