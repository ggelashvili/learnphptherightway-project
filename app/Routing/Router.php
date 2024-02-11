<?php

declare(strict_types=1);

namespace App\Routing;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    public function get(string $route, callable|array $action): self
    {
        return $this->register(HTTPMethod::GET, $route, $action);
    }

    public function register(
        HTTPMethod $requestMethod,
        string $route,
        callable|array $action
    ): self
    {
        $this->routes[$requestMethod->value][$route] = $action;

        return $this;
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register(HTTPMethod::POST, $route, $action);
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(string $requestUri, HTTPMethod $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod->value][$route] ?? null;

        if ( ! $action) {
            throw new RouteNotFoundException();
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)
                && method_exists(new $class(), $method)
            ) {
                return call_user_func([$class, $method]);
            }
        }

        return call_user_func($action);
    }
}
