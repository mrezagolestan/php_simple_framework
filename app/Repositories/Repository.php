<?php

namespace App\Repositories;

use Core\Utils\Database\DBInterface;

class Repository
{
    protected string $table = "";


    public function __construct(
        protected readonly DBInterface $db
    )
    {

    }

    public function findById(int $id): mixed
    {
        return $this->db->getSingle("SELECT * FROM " . $this->table . " WHERE id = " . $id);
    }

    public function getAll(): array|false
    {
        return $this->db->getAll("SELECT * FROM " . $this->table);
    }
}