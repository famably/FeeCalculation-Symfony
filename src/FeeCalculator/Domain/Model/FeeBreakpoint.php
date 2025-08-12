<?php

namespace Lendable\Interview\FeeCalculator\Domain\Model;

final class FeeBreakpoint
{
    public function __construct(
        private readonly float $amount,
        private readonly float $fee
    ) {
        if ($amount < 0 || $fee < 0) {
            throw new \InvalidArgumentException('Amount and fee must be positive numbers');
        }
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function fee(): float
    {
        return $this->fee;
    }
}