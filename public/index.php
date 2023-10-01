<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$service = new \App\DebtCollectionService();

echo $service->collectDebt(new \App\CollectionAgency()) . '<br>';

echo $service->collectDebt(new \App\Rocky()) . '<br>';
