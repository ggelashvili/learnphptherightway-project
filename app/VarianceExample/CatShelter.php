<?php

declare(strict_types=1);

namespace App\VarianceExample;

use Override;

class CatShelter implements AnimalShelter
{

    #[Override] public function adopt(string $name): Cat
    {
        return new Cat($name);
    }
}