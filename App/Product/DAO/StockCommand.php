<?php

namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

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
        return $this->DataBaseAccess->singleInsertCommand('INSERT INTO product_entries(
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
            )', [
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
        return $this->DataBaseAccess->executeCommand('DELETE FROM product_entries WHERE id = :id', [$id]);
    }

    public function update(int $id, array $fields): ?bool
    {
        if (empty($fields)) {
            return null;
        }

        return $this->DataBaseAccess->sendUpdate('product_entries', [
            'id' => $id,
            ...$fields,
        ]);
    }
}
