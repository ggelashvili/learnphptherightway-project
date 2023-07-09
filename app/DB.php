<?php

namespace App;
use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

public function __construct(array $config)
{
    $DEFAULT_OPTIONS=[PDO::ATTR_EMULATE_PREPARES=>false,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC];
    try {
        $this->pdo = new PDO($config['DRIVER'].':host=' . $config['HOST'] . ';dbname=' . $config['NAME'],
            $config['USER'],
            $config['PASS'],
            $config['options']??$DEFAULT_OPTIONS);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), $e->getCode());
    }
}
public function __call(string $name, array $arguments)
{
            return call_user_func_array([$this->pdo,$name],$arguments);
}
}