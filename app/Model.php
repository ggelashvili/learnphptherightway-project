<?php

declare(strict_types=1);

namespace App;

abstract class Model
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    /**
     * @return DB
     */
    public static function getDb(): DB
    {
        return App::db();
    }

    abstract public static function fetchAll(): array;

    abstract public function create(): self;

}
