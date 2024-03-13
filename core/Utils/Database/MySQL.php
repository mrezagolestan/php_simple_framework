<?php

namespace Core\Utils\Database;

use PDO;

class MySQL implements DBInterface
{
    private $connection;

    public function __construct(string $connection, string $host, string $port, string $db, string $user, string $pass)
    {
        $this->connection = new PDO("$connection:host=$host;dbname=$db", $user, $pass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAll(string $query, $type = PDO::FETCH_ASSOC)
    {
        return $this->connection->query($query)->fetchAll($type);
    }

    public function getSingle(string $query)
    {
        return $this->connection->query($query)->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(string $query, array $params): int
    {
        $statement = $this->connection->prepare($query);
        if (!$statement->execute($params)) {
            return 0;
        }
        return $this->connection->lastInsertId();
    }

    public function execute(string $query, array $params): bool
    {
        $statement = $this->connection->prepare($query);
        return $statement->execute($params);
    }
}