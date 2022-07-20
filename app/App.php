<?php

declare(strict_types = 1);

namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    private static DB $db;

    public function __construct(protected Router $router, protected Config $config)
    {
        static::$db = new DB($config->db ?? []);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(array $request)
    {
        try {
            echo $this->router->resolve($request['uri'], strtolower($request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}

//
