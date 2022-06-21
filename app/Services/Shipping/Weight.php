<?php

declare(strict_types = 1);

namespace App\Services\Shipping;

class Weight
{
    public function __construct(public readonly int $value)
    {
        if ($this->value <= 0 || $this->value > 150) {
            throw new \InvalidArgumentException('Invalid package weight');
        }
    }

    public function equalTo(Weight $other): bool
    {
        return $this->value === $other->value;
    }
}
