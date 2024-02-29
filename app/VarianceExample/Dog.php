<?php

namespace App\VarianceExample;

use Override;

class Dog extends Animal
{

    #[Override] public function makeSound(): void
    {
        echo $this->name . ' barks';
    }

    #[Override] public function eat(Food $food): void // Covariance Parameter Type: more specific -> less specific
    {
        echo $this->name . ' eats ' . get_class($food);
    }
}