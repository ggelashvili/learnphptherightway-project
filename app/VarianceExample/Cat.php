<?php

namespace App\VarianceExample;

class Cat extends Animal
{

    #[\Override] public function makeSound(): void
    {
        echo $this->name . ' meows';
    }

    #[\Override] public function eat(AnimalFood $food): void
    {
        echo $this->name . ' eats ' . get_class($food);
     }
}