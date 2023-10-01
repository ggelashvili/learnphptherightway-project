<?php

namespace App;

abstract class Field implements Renderable
{
    public function __construct(protected string $name)
    {

    }
}
