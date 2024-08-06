<?php

namespace Lib\Database;

use PDO;
use PDOStatement;

class DataBaseAccess implements DatabaseSendCommand
{
    public function __construct(private readonly PDO $PDO) {}

    public function executeCommand(string $query, array $params = []): bool
    {
        $PDOStatement = $this->PDO->prepare($query);

        return $PDOStatement->execute($params);
    }

    public function sendCommand(string $command, array $params = []): PDOStatement
    {
        $PDOStatement = $this->PDO->prepare($command);
        $PDOStatement->execute($params);

        return $PDOStatement;
    }
}
