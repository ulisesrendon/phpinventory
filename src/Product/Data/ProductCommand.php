<?php

namespace Stradow\Product\Data;

use Stradow\Framework\Database\DataBaseAccess;

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
     * @return bool|int|null
     */
    public function create(
        string $code,
        string $title,
        string $description = '',
        float $price = 0,
    ): null|bool|int|string {

        return $this->DataBaseAccess->insert('products', [
            'code' => $code,
            'title' => $title,
            'description' => $description,
            'price' => $price,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->DataBaseAccess->delete('products', $id);
    }

    public function update(array $fields): ?bool
    {
        return $this->DataBaseAccess->update('products', $fields);
    }
}
