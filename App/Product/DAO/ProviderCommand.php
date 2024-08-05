<?php

namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

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
        return $this->DataBaseAccess->singleInsertCommand('INSERT INTO providers(
                title,
                description
            ) VALUES(
                :title,
                :description
            )', [
            'title' => $title,
            'description' => $description,
        ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DataBaseAccess->executeCommand('DELETE FROM providers WHERE id = :id', [$id]);
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

        return $this->DataBaseAccess->executeCommand("UPDATE providers SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }
}