<?php

declare(strict_types=1);

namespace App\VarianceExample;

use Override;

class DogShelter implements AnimalShelter
{

    #[Override] public function adopt(string $name): Dog
    {
        return new Dog($name);
    }
}