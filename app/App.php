<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Routing\HTTPRequest;
use app\Routing\Router;
use App\Ui\View;

class App
{
    private static DB $db;

    public function __construct(
        protected Router $router,
        protected HTTPRequest $request,
        protected Config $config
    )
    {
        static::$db = new DB($config->db ?? []);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve(
                $this->request->uri,
                $this->request->method
            );
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
