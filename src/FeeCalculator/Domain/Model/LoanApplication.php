<?php

namespace Lendable\Interview\FeeCalculator\Domain\Model;

final class LoanApplication
{
    public function __construct(
        private readonly float $amount,
        private readonly int $term
    ) {
        if ($amount < 1000 || $amount > 20000) {
            throw new \InvalidArgumentException('Loan amount must be between £1,000 and £20,000');
        }

        if (!in_array($term, [12, 24], true)) {
            throw new \InvalidArgumentException('Loan term must be either 12 or 24 months');
        }
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function term(): int
    {
        return $this->term;
    }
}