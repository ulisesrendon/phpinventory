<?php
namespace Lib\Database;

interface DatabaseTransaction
{
    public function beginTransaction(): bool;

    public function commit(): bool;

    public function rollBack(): bool;
}