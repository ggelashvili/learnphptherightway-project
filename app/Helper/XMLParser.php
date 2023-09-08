<?php

declare(strict_types=1);

namespace App\Helper;

class XMLParser
{
    public static function parse(string $line): array
    {
        if (empty($line)) return [];

        $data = explode(',"', $line);

        $info = array_map(function ($item) {
            return (is_numeric($item)) ? (float) $item : $item;
        }, explode(',', $data[0]));

        $info = explode(',', $data[0]);
        $amount = trim($data[1]);
        $amount = str_replace(['$', '"', ','], '', $data[1]);

        return [
            'date' => $info[0],
            'check' => $info[1],
            'description' => $info[2],
            'amount' => $amount,
        ];
    }
}
