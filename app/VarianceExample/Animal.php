<?php

namespace App\VarianceExample;

abstract class Animal
{
    public function __construct(protected string $name)
    {
    }

    abstract public function makeSound(): void;
    abstract public function eat(AnimalFood $food): void;
}