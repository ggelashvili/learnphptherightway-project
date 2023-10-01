<?php

namespace App;

interface DebtCollectorInterface
//extends SomeOtherInterface, AnotherInterface
{
//    public const MY_CONST = 1;
//    public function __construct();
    public function collect(float $owedAmount): float;
}
