<?php

namespace App;

/**
 * @property int $c
 * @property-read int $x
 * @property-write int $y
 * @method static int bar(string $x)
 */
class Transaction
{
    /** @var Customer */
    private Customer $customer;

    /** @var float */
    private float $amount;

    /**
     * Some description
     *
     * @param Customer $customer
     * @param float|int $amount
     *
     * @return bool
     * @throws \InvalidArgumentException
     *
     * @throws \RuntimeException
     */
    public function process(Customer $customer, float|int $amount): bool
    {
        // process transaction

        // if failed, return false

        // otherwise return true

        return true;
    }

    /**
     * @param Customer[] $arr
     * @return void
     */
    public function foo(array $arr)
    {
        foreach ($arr as $obj) {
            $obj->name;
            $obj->myMethod();
        }
    }

    public function __get(string $name)
    {
        // TODO: Implement __get() method.
    }

    public function __set(string $name, $value): void
    {
        // TODO: Implement __set() method.
    }

    public static function __callStatic(string $name, array $arguments)
    {
        // TODO: Implement __callStatic() method.
    }
}
