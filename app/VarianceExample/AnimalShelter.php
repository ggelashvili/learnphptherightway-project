<?php

namespace App\VarianceExample;

interface AnimalShelter
{
    public function adopt(string $name): Animal;
}