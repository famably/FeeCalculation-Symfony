<?php

namespace Lendable\Interview\FeeCalculator\Domain\Service;

use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpoint;
use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpointList;

final class FeeInterpolator
{
    public function interpolate(float $amount, FeeBreakpointList $breakpoints): float
    {
        if ($breakpoints->isEmpty()) {
            throw new \RuntimeException('Cannot interpolate with empty breakpoints list');
        }

        $previous = null;
        foreach ($breakpoints as $current) {
            if ($amount == $current->amount()) {
                return $current->fee();
            }

            if ($amount < $current->amount()) {
                if ($previous === null) {
                    return $current->fee();
                }
                return $this->linearInterpolate($amount, $previous, $current);
            }

            $previous = $current;
        }

        return $current->fee(); // Amount is higher than last breakpoint
    }

    private function linearInterpolate(float $amount, FeeBreakpoint $lower, FeeBreakpoint $upper): float
    {
        $amountRange = $upper->amount() - $lower->amount();
        $feeRange = $upper->fee() - $lower->fee();
        $position = ($amount - $lower->amount()) / $amountRange;

        return $lower->fee() + ($feeRange * $position);
    }
}