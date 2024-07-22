<?php
namespace App\Lib\Database;

use PDO;
use PDOStatement;

abstract class DB
{

    static public $dbh;

    static public function connect()
    {
        self::$dbh = new PDO(
            'pgsql:host=localhost;port=5432;dbname=phpinventory',
            'postgres',
            'Lorem2023',
            [
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]
        );
    }

    /*
     * Retorna un string con la consulta SQL reemplazando los parámetros
     */
    static public function getQueryString(string $query, array $params = []): string
    {
        $replacement = [];
        foreach ($params as $key => $value) {
            $replacement["/$key/"] = (is_string($value)) ? "\"$value\"" : $value;
        }
        return (string) preg_replace(array_keys($replacement), array_values($replacement), $query);
    }

    /*
     * Permite ejecutar consultas y retorna true o false dependiendo de la consulta
     */
    static public function executeCommand(string $query, array $params = []): bool
    {
        $PDOStatement = self::$dbh->prepare($query);
        return $PDOStatement->execute($params);
    }

    static public function sendCommand(string $command, array $params = []): PDOStatement
    {
        $PDOStatement = self::$dbh->prepare($command);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /*
     * Permite ejecutar consultas SELECT y retorna un arreglo asociativo
     */
    static public function fetchQuery(string $query, array $params = []): ?array
    {
        $PDOStatement = self::$dbh->prepare($query);
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

    /*
     * Permite ejecutar consultas SELECT y retorna la primera fila
     */
    static public function fetchFirst(string $query, array $params = []): ?object
    {
        $result = self::fetchQuery($query, $params);
        if ($result) {
            return $result[0];
        }
        return null;
    }
}