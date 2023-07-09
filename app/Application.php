<?php

namespace App;


use \App\Exceptions\RouteNotFoundException;


class Application
{
    private static DB $db;

    public function __construct(protected Router $router, protected array  $requests, protected Config $config)
    {
     static::$db=new DB($config->db??[]);

    }
    public static function db() : DB
    {
        return static::$db;
    }


    public function run():void
    {
        try {
            echo $this->router->resolve($this->requests['method'], $this->requests['uri']);

        } catch (RouteNotFoundException) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            echo View::make('errors/404');

        }
    }
}








