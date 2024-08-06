<?php

namespace Lib\Database;

use PDO;

class DataBaseAccess implements DatabaseTransaction
{
    public function __construct(private readonly PDO $PDO) {}

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
