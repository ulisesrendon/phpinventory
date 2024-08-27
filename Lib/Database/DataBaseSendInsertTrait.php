<?php

namespace Lib\Database;

trait DataBaseSendInsertTrait
{
    public function sendInsert(DataBaseAccess $DataBaseAccess, string $table, array $fields): null|bool|int|string
    {
        if (empty($fields)) {
            return null;
        }

        $ColumnNames = implode(', ', array_keys($fields));

        $FieldsString = implode(', ', array_map(fn ($field) => ":$field", array_keys($fields)));

        return $DataBaseAccess->singleInsertCommand("INSERT INTO $table($ColumnNames) values($FieldsString)", $fields);
    }
}
