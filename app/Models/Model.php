<?php

namespace App\Models;

use App\App;
use App\DB;

abstract class Model
{
    protected DB $db;
    protected string $table;

    public function __construct()
    {
        $this->db = App::db();
    }

    /**
     * Fetch record(s)
     * @param array $conditions
     * @param int|string $recordsLimit
     * @return array
     */
    public function find(array $conditions = [], int|string $recordsLimit = 'all'): array
    {
        $query = "SELECT * FROM {$this->table}";
        $whereStatement = '';

        if(!empty($conditions)) {
            $whereStatement .= ' WHERE ';

            $whereStatement .= implode(' AND ', array_map(function ($key) {
                return "{$key}=:{$key}";
            }, array_keys($conditions)));

            $query .= $whereStatement;
        }

        if($recordsLimit !== 'all') {
            // if isn't set to `all` then accept only integers (For ex: LIMIT 5)
            if(is_int($recordsLimit)) {
                $query .= " LIMIT {$recordsLimit}";
            } else {
                throw new \Exception('Param not supported');
            }
        }

        $stmt = $this->bindAndExecuteQuery($query, $conditions);
        return $stmt->fetchAll();
    }

    public function create(array $attrs): void
    {
        $query = $this->buildInsertQuery($attrs);
        $this->bindAndExecuteQuery($query, $attrs);
    }

    private function buildInsertQuery(array $attrs): string
    {
        $insertColumns = implode(', ', array_keys($attrs));
        $insertValues = implode(', ', array_map(function ($key) {
            return ":{$key}";
        }, array_keys($attrs)));

        return "INSERT INTO {$this->table} ({$insertColumns}) VALUES ({$insertValues})";
    }

    private function bindAndExecuteQuery(string $query, array $attrs = []): \PDOStatement
    {
        $stmt = $this->db->prepare($query);

        if(!empty($attrs)) {
            foreach ($attrs as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
        }

        $stmt->execute();
        return $stmt;
    }
}