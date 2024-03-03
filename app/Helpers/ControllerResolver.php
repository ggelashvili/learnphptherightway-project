<?php

namespace App\Helpers;

use App\Attributes\Controller;
use ReflectionClass;
use RuntimeException;

class ControllerResolver
{
    private const NAMESPACE_SEPARATOR = '\\';

    public function getControllersFromNamespace(string $namespace): array
    {
        if ( ! str_ends_with($namespace, self::NAMESPACE_SEPARATOR)) {
            $namespace .= self::NAMESPACE_SEPARATOR;
        }

        $controllersDirname = $this->resolveControllersDirectoryFromNamespace($namespace);

        if ( ! is_dir($controllersDirname)) {
            throw new RuntimeException('Invalid namespace value');
        }

        $files = scandir($controllersDirname);
        return $this->filterControllers($files, $namespace);
    }

    private function filterControllers(array $classes, string $namespace): array
    {
        return array_reduce(
            $classes,
            function (array $controllers, string $filename) use ($namespace) {
                $controllerClass = $namespace . rtrim($filename, '.ph');
                if (class_exists($controllerClass)) {
                    $reflectionController = new ReflectionClass($controllerClass);

                    $attributes = $reflectionController->getAttributes(Controller::class);
                    if ( ! empty($attributes)) {
                        $controllers[] = $controllerClass;
                    }
                }
                return $controllers;
            },
            array()
        );
    }

    private function resolveControllersDirectoryFromNamespace(string $namespace): string
    {
        return ROOT_DIR .
               str_replace(
                   [self::NAMESPACE_SEPARATOR, ucfirst(APP_DIR)],
                   [DIRECTORY_SEPARATOR, APP_DIR],
                   $namespace
               );
    }
}