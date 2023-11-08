<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\Migration;

use RuntimeException;

class Migration extends \yii\db\Migration
{
    protected string $tableOptions = '';
    protected string $restrict = 'RESTRICT';
    protected string $cascade = 'CASCADE';

    public function init(): void
    {
        match ($this->db->driverName) {
            'mysql' => $this->tableOptions = 'CHARACTER SET utf8mb4 ENGINE=InnoDB',
            'pgsql', 'sqlite' => $this->tableOptions = '',
            'dblib', 'mssql', 'sqlsrv' => $this->restrict = 'NO ACTION',
            default => throw new RuntimeException('Your database is not supported!'),
        };
    }

    public function hasForeingKey(string $tableName, string $name): bool
    {
        return $this->db->getTableSchema($tableName, true)->getForeignKey($name) !== null;
    }

    public function hasTable(string $tableName): bool
    {
        return $this->db->getTableSchema($tableName, true) !== null;
    }
}
