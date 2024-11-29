<?php

use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

function instancePDO(
    string $drive,
    string $host,
    int $port,
    string $name,
    string $user,
    string $password,
): PDO
{
    $PDO = new PDO(
        dsn: "$drive:host=$host;port=$port;dbname=$name",
        username: $user,
        password: $password,
    );
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $PDO;
}

Container::add(
    className: DataBaseAccess::class, 
    instance: new DataBaseAccess(instancePDO(
        drive: DB_CONFIG['mainrdb']['drive'],
        host: DB_CONFIG['mainrdb']['host'],
        port: DB_CONFIG['mainrdb']['port'],
        name: DB_CONFIG['mainrdb']['name'],
        user: DB_CONFIG['mainrdb']['user'],
        password: DB_CONFIG['mainrdb']['password'],
    )
));
