<?php

namespace Tests\DataProviders;

class RouterDataProvider
{

    public static function routeNotFoundCases(): array
    {
        return [
            ['/invoices', 'get',],
            ['/users', 'put',],
            ['/invoices', 'post'],
            ['/users', 'invalid request name',],
        ];
    }
}