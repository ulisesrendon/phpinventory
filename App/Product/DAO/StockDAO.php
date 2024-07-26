<?php
namespace App\Product\DAO;

use Lib\Database\DefaultModel;

class StockDAO extends DefaultModel
{

    public function create(
        int $product_id,
        int $quantity,
        ?int $provider_id = null,
        float $cost = 0,
        ?string $lot = null,
        ?string $expiration_date = null,
    ): bool|string|null
    {
        return $this->DBA->singleInsertCommand("INSERT INTO product_entries(
                product_id,
                quantity,
                provider_id,
                cost,
                lot,
                expiration_date
            ) VALUES(
                :product_id,
                :quantity,
                :provider_id,
                :cost,
                :lot,
                :expiration_date
            )", [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'provider_id' => $provider_id,
                'cost' => $cost,
                'lot' => $lot,
                'expiration_date' => $expiration_date,
            ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DBA->executeCommand("DELETE FROM product_entries 
            WHERE id = :id and stock_sync is not true
            ", [$id]);
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
                product_stocks.price as price_alt,
                product_entries.provider_id,
                providers.title as provider_title,
                product_entries.created_at
            from product_entries
            left join products on products.id = product_entries.product_id
            left join product_stocks on product_stocks.product_entry_id = product_entries.id
            left join providers on providers.id = product_entries.provider_id
            where product_entries.product_id = :id
            order by product_entries.created_at desc
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

    public function productIdExists(int $id): ?bool
    {
        return $this->DBA->fetchScalar("SELECT exists(
            SELECT id from products where id = :id
        )", [$id]);
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

        return $this->DBA->executeCommand("UPDATE product_entries SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }
}