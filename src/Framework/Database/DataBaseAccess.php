<?php

namespace Stradow\Framework\Database;

use PDO;
use InvalidArgumentException;
use Stradow\Framework\Database\Event\QueryExecuted;
use Stradow\Framework\Database\Event\CommandExecuted;
use Stradow\Framework\Database\Interface\DatabaseFetchQuery;
use Stradow\Framework\Database\Interface\DatabaseSendCommand;
use Stradow\Framework\Database\Interface\DatabaseTransaction;

class DataBaseAccess implements DatabaseFetchQuery, DatabaseSendCommand, DatabaseTransaction
{
    private readonly PDO $PDO;
    private ?object $EventDispatcher;

    public function __construct(
        PDO $PDO,
        ?object $EventDispatcher = null,
    )
    {
        $this->PDO = $PDO;
        $this->EventDispatcher = $EventDispatcher;
    }

    public function getQueryString(string $query, array $params = []): string
    {
        $replacement = [];
        foreach ($params as $key => $value) {
            $replacement["/\:$key/"] = (is_string($value)) ? "\"$value\"" : $value;
        }

        return (string) preg_replace(array_keys($replacement), array_values($replacement), $query);
    }

    /**
     * Execute a database command
     */
    public function command(string $query, array $params = []): bool
    {
        if (!is_null(value: $this->EventDispatcher)) {
            $this->EventDispatcher->dispatch(new CommandExecuted($query, $params));
        }

        $PDOStatement = $this->PDO->prepare($query);

        return $PDOStatement->execute($params);
    }

    /**
     * Fetch all the results from a query
     */
    public function query(
        string $query, 
        array $params = [],
        ?string $class = null,
    ): ?array
    {
        if(!is_null(value: $this->EventDispatcher)){
            $this->EventDispatcher->dispatch(new QueryExecuted($query, $params));
        }

        $PDOStatement = $this->PDO->prepare($query);
        $result = $PDOStatement->execute($params);
        if ($result) {
            if(!is_null($class)){
                return $PDOStatement->fetchAll(PDO::FETCH_CLASS, $class);
            }
            return $PDOStatement->fetchAll(PDO::FETCH_OBJ);
        }

        return null;
    }

    public function beginTransaction(): bool
    {
        return $this->PDO->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->PDO->commit();
    }

    public function rollBack(): bool
    {
        return $this->PDO->rollBack();
    }

    public function getConnection(): PDO
    {
        return $this->PDO;
    }

    /**
     * Execute a database insert command and return last inserted id
     */
    public function create(string $table, array $fields): null|bool|int|string
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
    public function insert(string $table, array $data): ?bool
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
                throw new InvalidArgumentException('Not all rows have the same fields');
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

    public function select(string $query, array $params = [], ?string $class = null,): ?object
    {
        $result = $this->query($query, $params, $class);
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
