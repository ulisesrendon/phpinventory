<?php

namespace App\Product\DAO;

use App\Framework\Database\DataBaseAccess;

class StockCommand
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function create(
        int $product_id,
        int $quantity,
        ?int $provider_id = null,
        float $cost = 0,
        ?string $lot = null,
        ?string $expiration_date = null,
    ): bool|string|null {

        return $this->DataBaseAccess->insert('product_entries', [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'provider_id' => $provider_id,
            'cost' => $cost,
            'lot' => $lot,
            'expiration_date' => $expiration_date,
        ]);
    }

    public function deleteEntryById(int $id): bool
    {
        return $this->DataBaseAccess->delete('product_entries', $id);
    }

    public function update(array $fields): ?bool
    {
        return $this->DataBaseAccess->update('product_entries', $fields);
    }
}
