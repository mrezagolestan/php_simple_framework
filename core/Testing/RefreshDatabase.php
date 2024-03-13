<?php

namespace Core\Testing;

use App\Provision;
use Core\Utils\Database\DBInterface;

trait RefreshDatabase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function refreshDatabase($provision = true)
    {
        $this->dropTables();

        if ($provision) {
            $this->migrations();
            app()->resolve(Provision::class)->run();
        }
    }

    private function dropTables()
    {
        $db = app()->resolve(DBInterface::class);
        $tables = $db->getAll('show tables;', \PDO::FETCH_COLUMN);

        $db->execute('SET FOREIGN_KEY_CHECKS=0;', []);
        foreach ($tables as $table) {
            $db->execute('DROP TABLE ' . $table, []);
        }
    }


    private function migrations()
    {
        $db = app()->resolve(DBInterface::class);

        $migrations = file_get_contents(APP_DIR . 'migrations.sql');
        $action = $db->execute($migrations, []);
    }
}