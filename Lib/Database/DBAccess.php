<?php
namespace Lib\Database;

use PDO;
use PDOStatement;

/**
 * DBAccess - Database Access Layer
 */
class DBAccess
{

    /**
     * Database Connection
     * @var 
     */
    static public $connection;

    /**
     * Summary of connect
     * @param string $drive
     * @param string $host
     * @param int $port
     * @param string $name
     * @param string $user
     * @param string $password
     * @return PDO
     */
    public static function connect(
        string $drive = 'pgsql',
        string $host = 'localhost',
        int $port = 5432,
        string $name = 'postgres',
        string $user = 'postgres',
        string $password = '',
    )
    {
        self::$connection = new PDO(
            "$drive:host=$host;port=$port;dbname=$name",
            $user,
            $password,
            [
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]
        );

        return self::$connection;
    }

    /**
     * Return sql string binding params
     * @param string $query
     * @param array $params
     * @return string
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
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function executeCommand(string $query, array $params = []): bool
    {
        $PDOStatement = self::$connection->prepare($query);
        return $PDOStatement->execute($params);
    }

    /**
     * Execute a database insert command and return last inserted id
     * @param string $query
     * @param array $params
     * @return bool|string|null
     */
    public function singleInsertCommand(string $query, array $params = []): bool|string|null
    {
        $PDOStatement = self::$connection->prepare($query);
        $result = $PDOStatement->execute($params);
        return $result ? self::$connection->lastInsertId() : null;
    }

    /**
     * Send a database command
     * @param string $command
     * @param array $params
     * @return \PDOStatement
     */
    public function sendCommand(string $command, array $params = []): PDOStatement
    {
        $PDOStatement = self::$connection->prepare($command);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * Fetch all the results from a query
     * @param string $query
     * @param array $params
     * @return array|null
     */
    public function fetchQuery(string $query, array $params = []): ?array
    {
        $PDOStatement = self::$connection->prepare($query);
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
     * @param string $query
     * @param array $params
     * @return array|object
     */
    public function fetchFirst(string $query, array $params = []): ?object
    {
        $result = self::fetchQuery($query, $params);
        if (!empty($result)) {
            return $result[0];
        }
        return null;
    }

    /**
     * Fetch a scalar result from query
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function fetchScalar(string $query, array $params = []): mixed
    {
        $PDOStatement = self::$connection->prepare($query);
        $result = $PDOStatement->execute($params);
        if ($result) {
            return $PDOStatement->fetchColumn();
        }
        return null;
    }
}