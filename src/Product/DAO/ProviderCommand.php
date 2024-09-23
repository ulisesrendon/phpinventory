<?php

namespace App\Product\DAO;

use App\Shared\Database\DataBaseAccess;
use App\Shared\Database\DataBaseSendInsertTrait;
use App\Shared\Database\DataBaseSendUpdateTrait;

class ProviderCommand
{
    use DataBaseSendInsertTrait;
    use DataBaseSendUpdateTrait;

    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function create(
        string $title,
        string $description = '',
    ): bool|string|null {
        return $this->sendInsert($this->DataBaseAccess, 'providers', [
            'title' => $title,
            'description' => $description,
        ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DataBaseAccess->executeCommand('DELETE FROM providers WHERE id = :id', ['id' => $id]);
    }

    public function update(int $id, array $fields): ?bool
    {
        if (empty($fields)) {
            return null;
        }

        $fields['id'] = $id;

        return $this->sendUpdate($this->DataBaseAccess, 'providers', $fields);
    }
}
