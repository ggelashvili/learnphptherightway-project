<?php

declare(strict_types = 1);

namespace App\Services\Shipping;

class PackageDimension
{
    public function __construct(public readonly int $width, public readonly int $height, public readonly int $length)
    {
        match(true) {
            $this->width <= 0 || $this->width > 80 => throw new \InvalidArgumentException('Invalid package width'),
            $this->height <= 0 || $this->height > 70 => throw new \InvalidArgumentException('Invalid package height'),
            $this->length <= 0 || $this->length > 120 => throw new \InvalidArgumentException('Invalid package length'),
            default => true,
        };
    }

    public function increaseWidth(int $width): self
    {
        return new self($this->width + $width, $this->height, $this->length);
    }

    public function equalTo(PackageDimension $other): bool
    {
        return $this->width === $other->width
            && $this->height === $other->height
            && $this->length === $other->length;
    }
}
