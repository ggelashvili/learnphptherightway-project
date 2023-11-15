<?php

declare(strict_types=1);

namespace Tests\Unit\DataProviders;

class ContainerDataProvider
{
    public function throwExceptionProviders(): array
    {
        return [
            [\Tests\Unit\DataProviders\A::class],
            [\Tests\Unit\DataProviders\B::class],
            [\Tests\Unit\DataProviders\C::class],
            [\Tests\Unit\DataProviders\D::class]
        ];
    }
}

// Not instantiable
abstract class A
{
}

// Construct parameter without type
class B
{
    public function __construct($a)
    {
    }
}

// Construct parameter is union type
class C
{
    public function __construct(string|int $a)
    {
    }
}

// Construct parameter is built-in type
class D
{
    public function __construct(string $a)
    {
    }
}