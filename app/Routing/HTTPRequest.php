<?php

namespace App\Routing;

readonly class HTTPRequest
{
    public function __construct(
        public string $uri,
        public HTTPMethod $method
    ) {
    }
}