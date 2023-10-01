<?php

namespace App;

class CollectionAgency implements DebtCollectorInterface
{
    public function collect(float $owedAmount): float
    {
        $guaranteed = $owedAmount * 0.5;

        return mt_rand($guaranteed, $owedAmount);
    }
}
