<?php
namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

class ProductDAO
{
    public DataBaseAccess $DataBaseAccess;
    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    /**
     * Save new product data
     * @param string $code
     * @param string $title
     * @param string $descriptionf
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
        return $this->DataBaseAccess->singleInsertCommand("INSERT INTO products(
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
        return $this->DataBaseAccess->executeCommand("DELETE FROM products WHERE id = :id", [$id]);
    }

    public function update(int $id, array $fields): ?bool
    {
        if (empty($fields)) {
            return null;
        }

        $FieldsCompacted = [];
        foreach ($fields as $field => $value) {
            $FieldsCompacted[] = "$field = :$field";
        }
        $FieldsString = implode(', ', $FieldsCompacted);

        return $this->DataBaseAccess->executeCommand("UPDATE products SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }

    public function getByID(int $id): ?array
    {
        return $this->DataBaseAccess->fetchQuery("SELECT 
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
        ", [$id]);
    }

    public function codeExists(string $code): ?bool
    {
        return $this->DataBaseAccess->fetchScalar("SELECT exists(
            SELECT products.code from products where products.code = :code
        )", [$code]);
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->fetchQuery("SELECT 
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