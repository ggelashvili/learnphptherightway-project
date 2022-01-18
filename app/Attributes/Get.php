<?php

declare(strict_types = 1);

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Get extends Route
{
    public function __construct(string $routePath)
    {
        parent::__construct($routePath);
    }
}
