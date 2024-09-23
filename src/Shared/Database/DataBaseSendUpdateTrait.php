<?php

namespace App\Shared\Database;

trait DataBaseSendUpdateTrait
{
    public function sendUpdate(DataBaseAccess $DataBaseAccess, string $table, array $fields): ?bool
    {
        if (empty($fields) || ! isset($fields['id'])) {
            return null;
        }

        $id = $fields['id'];
        unset($fields['id']);

        $FieldNames = [];
        foreach ($fields as $field => $value) {
            $FieldNames[] = "$field = :$field";
        }

        $FieldsString = implode(', ', $FieldNames);

        return $DataBaseAccess->executeCommand("UPDATE $table SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }
}
