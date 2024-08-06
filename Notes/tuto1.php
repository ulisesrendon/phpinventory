<?php

namespace Lib\Database;

use PDO;

class DataBaseAccess implements DatabaseFetchQuery
{
    public function __construct(private readonly PDO $PDO)
    {
    }

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
}

$PDO = new PDO("$drive:host=$host;port=$port;dbname=$name", $user, $password);
$PDOStatement = $PDO->prepare($query);
$PDOStatement->execute($params);
$PDOStatement->fetch(PDO::FETCH_OBJ);
$PDO->lastInsertId();
$PDO->beginTransaction();
$PDO->commit();
$PDO->rollBack();

// Database conexion
$PDO = new PDO("$drive:host=$host;port=$port;dbname=$name", $user, $password);

// Create database schema
$PDO->prepare($query)->execute();

// Read data
$PDOStatement = $PDO->prepare($query);
$rows = [];
if ($PDOStatement->execute($params)) {
    while ($row = $PDOStatement->fetch(PDO::FETCH_OBJ)) {
        $rows[] = $row;
    }
}

// Create data
$PDO->prepare($query)->execute($params);
$PDO->lastInsertId();

// Update data
$PDO->prepare($query)->execute($params);

// Delete data
$PDO->prepare($query)->execute($params);



// Create database schema
$query = "CREATE products IF NOT EXISTS(
    id bigserial not null primary key,
    code varchar(255) null unique,
    title varchar(255) null,
    price numeric(10, 2) not null default 0,
    stock integer not null default 0,
    active boolean not null default false,
    deleted_at timestamp(0) null
)";
$PDO->prepare($query)->execute();

$query = "INSERT INTO products(code, title, price, active) VALUES($code, $title, $price, $active)";