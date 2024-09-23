<?php

namespace App\Product\DAO;

use App\Shared\Database\DataBaseAccess;
use App\Shared\Database\DataBaseSendInsertTrait;
use App\Shared\Database\DataBaseSendUpdateTrait;

class ProductCommand
{
    use DataBaseSendInsertTrait;
    use DataBaseSendUpdateTrait;

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

        return $this->sendInsert($this->DataBaseAccess, 'products', [
            'code' => $code,
            'title' => $title,
            'description' => $description,
            'price' => $price,
        ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DataBaseAccess->executeCommand('DELETE FROM products WHERE id = :id', ['id' => $id]);
    }

    public function update(int $id, array $fields): ?bool
    {
        if (empty($fields)) {
            return null;
        }

        $fields['id'] = $id;

        return $this->sendUpdate($this->DataBaseAccess, 'products', $fields);
    }
}
