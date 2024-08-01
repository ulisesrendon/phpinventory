<?php

namespace Lib\Database;

use PDO;

class PDOContainer implements DatabaseObjectContainer
{
    protected readonly PDO $PDO;

    public function __construct(
        string $drive,
        int $port,
        string $name,
        string $user,
        string $host = 'localhost',
        string $password = '',
    ) {
        $this->PDO = new PDO(
            "$drive:host=$host;port=$port;dbname=$name",
            $user,
            $password
        );
    }

    public function get(): PDO
    {
        return $this->PDO;
    }
}
