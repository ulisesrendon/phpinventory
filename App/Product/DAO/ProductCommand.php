<?php

namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

class ProductCommand
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    /**
     * Save new product data
     *
     * @param  string  $descriptionf
     * @return bool|int|null
     */
    public function create(
        string $code,
        string $title,
        string $description = '',
        float $price = 0,
    ): bool|string|null {
        return $this->DataBaseAccess->singleInsertCommand('INSERT INTO products(
                code,
                title,
                description,
                price
            ) VALUES(
                :code,
                :title,
                :description,
                :price
            )', [
            'code' => $code,
            'title' => $title,
            'description' => $description,
            'price' => $price,
        ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DataBaseAccess->executeCommand('DELETE FROM products WHERE id = :id', [$id]);
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
}
