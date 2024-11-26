<?php

namespace Stradow\Framework\Database;

use InvalidArgumentException;

class DataBaseAccess extends DataBaseBasicAccess
{
    /**
     * Execute a database insert command and return last inserted id
     */
    public function insert(string $table, array $fields): null|bool|int|string
    {
        if (empty($fields)) {
            return null;
        }

        $ColumnNames = implode(', ', array_keys($fields));
        $FieldsString = implode(', ', array_map(fn ($field) => ":$field", array_keys($fields)));

        $result = $this->command("INSERT INTO $table($ColumnNames) values($FieldsString)", $fields);

        return $result ? $this->PDO->lastInsertId() : null;
    }

    /**
     * Execute a single database insert command with multiple values
     */
    public function multiInsert(string $table, array $data): ?bool
    {
        if (empty($data)) {
            return null;
        }

        $dataFields = array_keys(array_values($data)[0]); // Get keys from first array

        $params = [];
        $fieldMarkers = [];

        foreach ($data as $index => $row) {
            $fieldMakers = [];

            if (count(array_diff_key($dataFields, array_keys($row))) > 0) {
                throw new InvalidArgumentException('Not all product lines have the same fields');
            }

            foreach ($row as $name => $value) {
                $paramName = "{$name}_{$index}";
                $params[$paramName] = $value;
                $fieldMakers[] = ":$paramName";
            }
            $fieldMarkers[] = '('.implode(', ', $fieldMakers).')';
        }

        $columnNames = implode(', ', $dataFields);
        $valuesString = implode(', ', $fieldMarkers);

        $result = $this->command(
            "INSERT INTO $table($columnNames) values $valuesString",
            $params
        );

        return $result;
    }

    public function select(string $query, array $params = []): ?object
    {
        $result = $this->query($query, $params);
        if (! empty($result)) {
            return $result[0];
        }

        return null;
    }

    /**
     * Fetch a scalar result from query
     */
    public function scalar(string $query, array $params = []): mixed
    {
        $PDOStatement = $this->PDO->prepare($query);
        $result = $PDOStatement->execute($params);
        if ($result) {
            return $PDOStatement->fetchColumn();
        }

        return null;
    }

    public function update(string $table, array $fields): ?bool
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

        return $this->command("UPDATE $table SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }

    public function delete(string $table, int $id): ?bool
    {
        return $this->command("DELETE FROM $table WHERE id = :id", ['id' => $id]);
    }
}
