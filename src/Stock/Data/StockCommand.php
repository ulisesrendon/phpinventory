<?php

namespace App\Stock\Data;

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
        int $pieces,
        ?int $provider_id = null,
        float $cost = 0,
        ?string $lot = null,
        ?string $expiration_date = null,
    ): bool|string|null {

        return $this->DataBaseAccess->insert('entrylines', [
            'product_id' => $product_id,
            'pieces' => $pieces,
            'provider_id' => $provider_id,
            'cost' => $cost,
            'lot' => $lot,
            'expiration_date' => $expiration_date,
        ]);
    }

    public function deleteEntryById(int $id): bool
    {
        return $this->DataBaseAccess->delete('entrylines', $id);
    }

    public function update(array $fields): ?bool
    {
        return $this->DataBaseAccess->update('entrylines', $fields);
    }
}
