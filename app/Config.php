<?php

declare(strict_types = 1);

namespace App;

/**
 * @property-read ?array $db
 * @property-read ?array $mailer
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db'      => [
                'host'      => $env['DB_HOST'],
                'username'  => $env['DB_USER'],
                'password'  => $env['DB_PASS'],
                'database'  => $env['DB_DATABASE'],
                'driver'    => $env['DB_DRIVER'] ?? 'mysql',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],
            'mailer'  => [
                'dsn' => $env['MAILER_DSN'] ?? '',
            ],
            'apiKeys' => [
                'emailable'                     => $env['EMAILABLE_API_KEY'] ?? '',
                'abstract_api_email_validation' => $env['ABSTRACT_API_EMAIL_VALIDATION_API_KEY'] ?? '',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
