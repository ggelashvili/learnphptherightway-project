<?php

declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Exceptions\RouteNotFoundException;
use Illuminate\Container\Container;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container)
    {
    }

    public function registerRoutesFromControllerAttributes(array $controllers)
    {
        foreach($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register($route->method->value, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
    }

    public function register(string $requestMethod, string $route, callable|array $action): self
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

        if (! $action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }
}
