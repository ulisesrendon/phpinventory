<?php

use App\Framework\Database\DataBaseAccess;
use App\Framework\DependencyResolver\Container;

$drive = DB_CONFIG['mainrdb']['drive'];
$host = DB_CONFIG['mainrdb']['host'];
$port = DB_CONFIG['mainrdb']['port'];
$name = DB_CONFIG['mainrdb']['name'];
$user = DB_CONFIG['mainrdb']['user'];
$password = DB_CONFIG['mainrdb']['password'];

$PDO = new PDO(
    "$drive:host=$host;port=$port;dbname=$name",
    $user,
    $password,
);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


$DataBaseAccess = new DataBaseAccess($PDO);
Container::add(DataBaseAccess::class, $DataBaseAccess);

return $DataBaseAccess;