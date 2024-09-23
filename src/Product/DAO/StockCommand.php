<?php

namespace App\Product\DAO;

use App\Shared\Database\DataBaseAccess;
use App\Shared\Database\DataBaseSendInsertTrait;
use App\Shared\Database\DataBaseSendUpdateTrait;

class StockCommand
{
    use DataBaseSendInsertTrait;
    use DataBaseSendUpdateTrait;

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

        return $this->sendInsert($this->DataBaseAccess, 'product_entries', [
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
        return $this->DataBaseAccess->executeCommand('DELETE FROM product_entries WHERE id = :id', ['id' => $id]);
    }

    public function update(int $id, array $fields): ?bool
    {
        if (empty($fields)) {
            return null;
        }

        $fields['id'] = $id;

        return $this->sendUpdate($this->DataBaseAccess, 'product_entries', $fields);
    }
}
