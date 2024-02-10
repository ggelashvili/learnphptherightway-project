<?php

declare(strict_types = 1);

namespace App;

use PDO;
use PDOException;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        [
            'driver'   => $driver,
            'host'     => $host,
            'name'     => $databaseName,
            'username' => $username,
            'password' => $password,
        ]
            = $config;

        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $options = $config['options'] ?? $defaultOptions;

        $dsn = "$driver:host=$host;dbname=$databaseName";

        try {
            $this->pdo = new PDO(
                $dsn, $username, $password, $options
            );
        } catch (PDOException $PDOException) {
            throw new PDOException(
                $PDOException->getMessage(), $PDOException->getCode()
            );
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}
