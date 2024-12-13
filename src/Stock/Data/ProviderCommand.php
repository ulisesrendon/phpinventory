<?php

namespace Stradow\Stock\Data;

use Stradow\Framework\Database\DataBaseAccess;

class ProviderCommand
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function create(
        string $title,
        string $description = '',
    ): bool|string|null {
        return $this->DataBaseAccess->create('providers', [
            'title' => $title,
            'description' => $description,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->DataBaseAccess->delete('providers', $id);
    }

    public function update(array $fields): ?bool
    {
        return $this->DataBaseAccess->update('providers', $fields);
    }
}
