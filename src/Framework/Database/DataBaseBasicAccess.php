<?php

namespace Stradow\Framework\Database;

use PDO;
use Stradow\Framework\Database\Interface\DatabaseFetchQuery;
use Stradow\Framework\Database\Interface\DatabaseSendCommand;
use Stradow\Framework\Database\Interface\DatabaseTransaction;

/**
 * DataBaseAccess - Database Access Layer
 */
class DataBaseBasicAccess implements DatabaseFetchQuery, DatabaseSendCommand, DatabaseTransaction
{
    protected readonly PDO $PDO;

    /**
     * Summary of __construct
     */
    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * Return sql string binding params
     */
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
        $PDOStatement = $this->PDO->prepare($query);

        return $PDOStatement->execute($params);
    }

    /**
     * Fetch all the results from a query
     */
    public function query(string $query, array $params = []): ?array
    {
        $PDOStatement = $this->PDO->prepare($query);
        $result = $PDOStatement->execute($params);
        if ($result) {
            $rows = [];
            while ($row = $PDOStatement->fetch(PDO::FETCH_OBJ)) {
                $rows[] = $row;
            }

            return $rows;
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
}
