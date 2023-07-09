<?php

namespace App;
/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config=[];

    public function __construct(array $env)
    {
        $this->config=['db'=>[
            'HOST'=>$env['DB_HOST'],
            'USER'=>$env['DB_USER'],
            'PASS'=>$env['DB_PASS'],
            'NAME'=>$env['DB_NAME'],
            'DRIVER'=>$env['DB_DRIVER']??'mysql']
                        ];
    }
    public function __get(string $name)
    {
        return $this->config[$name]??null;
    }
}