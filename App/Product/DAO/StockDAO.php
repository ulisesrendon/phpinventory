<?php
namespace App\Product\DAO;

use Lib\Database\DefaultModel;

class StockDAO extends DefaultModel
{

    /**
     * Save new product data
     * @param string $code
     * @param string $title
     * @param string $description
     * @param float $price
     * @return bool|int|null
     */
    public function create(
        string $code, 
        string $title,
        string $description = '',
        float $price = 0,
    ): bool|string|null
    {
        return $this->DBA->singleInsertCommand("INSERT INTO products(
                code,
                title,
                description,
                price
            ) VALUES(
                :code,
                :title,
                :description,
                :price
            )", [
                'code' => $code,
                'title' => $title,
                'description' => $description,
                'price' => $price,
            ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DBA->executeCommand("DELETE FROM products WHERE id = :id", [$id]);
    }

    public function getByProductID(int $id): ?array
    {
        return $this->DBA->fetchQuery("SELECT 
                product_entries.id,
                product_entries.lot,
                product_entries.quantity,
                product_stocks.stock,
                product_entries.stock_sync,
                products.price as base_price,
                product_stocks.price as price_alt
            from product_entries
            left join products on products.id = product_entries.product_id
            left join product_stocks on product_stocks.product_entry_id = product_entries.id
            where product_entries.product_id = :id
        ", [$id]);
    }

    public function getProductDataByID(int $id): ?object
    {
        return $this->DBA->fetchFirst("SELECT 
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
        ", [$id]);
    }

    public function codeExists(string $code): ?bool
    {
        return $this->DBA->fetchScalar("SELECT exists(
            SELECT products.code from products where products.code = :code
        )", [$code]);
    }

    public function list(): ?array
    {
        return $this->DBA->fetchQuery("SELECT 
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
        ");
    }

    public function update(int $id, array $fields): ?bool
    {
        if(empty($fields)){
            return null;
        }

        $FieldsCompacted = [];
        foreach($fields as $field => $value){
            $FieldsCompacted[] = "$field = :$field";
        }
        $FieldsString = implode(', ', $FieldsCompacted);

        return $this->DBA->executeCommand("UPDATE products SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }
}