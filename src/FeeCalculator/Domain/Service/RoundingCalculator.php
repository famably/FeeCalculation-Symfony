<?php

namespace Lendable\Interview\FeeCalculator\Domain\Service;

final class RoundingCalculator
{
    public function roundUpToFive(float $amount, float $fee): float
    {
        $total = $amount + $fee;
        $remainder = $total % 5;
        
        if ($remainder > 0) {
            $fee += (5 - $remainder);
        }
        
        return $fee;
    }
}