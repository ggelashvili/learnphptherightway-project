<?php

namespace App\Dto;

use App\Exceptions\InvalidPropertyAccessException;
use DateTimeInterface;

readonly class TransactionDTO
{
    public function __construct(
        public DateTimeInterface $date,
        public ?int $checkNumber,
        public string $description,
        public float $amount
    ) {
    }

    /**
     * @throws InvalidPropertyAccessException
     */
    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;

            return;
        }

        $formattedPropertyName = $this->snakeToCamel($name);

        if (property_exists($this, $formattedPropertyName)) {
            $this->$formattedPropertyName = $value;

            return;
        }

        throw new InvalidPropertyAccessException();
    }

    public function snakeToCamel(string $input): string
    {
        $words = explode('_', $input);

        $upperCamelCased = array_map('ucfirst', $words);

        return lcfirst(implode('', $upperCamelCased));
    }
}