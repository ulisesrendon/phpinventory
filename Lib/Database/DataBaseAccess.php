<?php

namespace Lib\Database;

use PDO;
use PDOStatement;

/**
 * DataBaseAccess - Database Access Layer
 */
class DataBaseAccess implements DatabaseFetchQuery, DatabaseSendCommand, DatabaseTransaction
{

    /**
     * Summary of __construct
     * @param \PDO $PDO
     */
    public function __construct(private readonly PDO $PDO) {}

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
    public function executeCommand(string $query, array $params = []): bool
    {
        $PDOStatement = $this->PDO->prepare($query);

        return $PDOStatement->execute($params);
    }

    /**
     * Execute a database insert command and return last inserted id
     */
    public function singleInsertCommand(string $query, array $params = []): bool|string|null
    {
        $result = $this->executeCommand($query, $params);

        return $result ? $this->PDO->lastInsertId() : null;
    }

    /**
     * Send a database command
     */
    public function sendCommand(string $command, array $params = []): PDOStatement
    {
        $PDOStatement = $this->PDO->prepare($command);
        $PDOStatement->execute($params);

        return $PDOStatement;
    }

    /**
     * Fetch all the results from a query
     */
    public function fetchQuery(string $query, array $params = []): ?array
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

    /**
     * Fetch the first result of a query
     *
     * @return array|object
     */
    public function fetchFirst(string $query, array $params = []): ?object
    {
        $result = self::fetchQuery($query, $params);
        if (! empty($result)) {
            return $result[0];
        }

        return null;
    }

    /**
     * Fetch a scalar result from query
     */
    public function fetchScalar(string $query, array $params = []): mixed
    {
        $PDOStatement = $this->PDO->prepare($query);
        $result = $PDOStatement->execute($params);
        if ($result) {
            return $PDOStatement->fetchColumn();
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
}
