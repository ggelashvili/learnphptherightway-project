<?php

declare(strict_types=1);

namespace App;

use Exception;
use InvalidArgumentException;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    private function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }


        if (!is_array($action)) {
            throw new InvalidArgumentException();
        }

        [$controllerClass, $method] = $action;
        if (!class_exists($controllerClass)) {
            throw new Exception('Method Not Allowed');
        }

        $controller = new $controllerClass();
        if (! method_exists($controller, $method)) {
            throw new Exception('Method Not Allowed');
        }

        return call_user_func_array([$controller, $method], []);
    }
}
