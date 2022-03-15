<?php

declare(strict_types = 1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * @mixin Connection
 */
class DB
{
    private Connection $connection;

    public function __construct(array $config)
    {
        $this->connection = DriverManager::getConnection($config);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}
