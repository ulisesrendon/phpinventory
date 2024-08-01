<?php

namespace Lib\Database;

/**
 * It Works with Database Transactions
 */
interface DatabaseTransaction
{
    public function beginTransaction(): bool;

    public function commit(): bool;

    public function rollBack(): bool;
}
