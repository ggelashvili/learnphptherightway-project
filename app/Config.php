<?php

declare(strict_types = 1);

namespace App;

/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST'],
                'username' => $env['DB_USERNAME'],
                'password' => $env['DB_USER_PASSWORD'],
                'name'     => $env['DB_NAME'],
                'driver'   => $env['DB_DRIVER'] ?? 'mysql',
            ]
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
