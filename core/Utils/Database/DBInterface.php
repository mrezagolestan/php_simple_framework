<?php

namespace Core\Utils\Database;

interface DBInterface
{

    public function __construct(string $connection, string $host, string $port, string $db, string $user, string $pass);

    public function getAll(string $query, $type);

    public function getSingle(string $query);

    public function insert(string $query, array $params): int;

    public function execute(string $query, array $params): bool;
}