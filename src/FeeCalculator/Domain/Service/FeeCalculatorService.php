<?php

namespace Lendable\Interview\FeeCalculator\Domain\Service;

use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpointList;
use Lendable\Interview\FeeCalculator\Domain\Model\LoanApplication;

final class FeeCalculatorService
{
    public function __construct(
        private FeeInterpolator $interpolator,
        private RoundingCalculator $roundingCalculator
    ) {}

    public function calculate(LoanApplication $application, FeeBreakpointList $breakpoints): float
    {
        $baseFee = $this->interpolator->interpolate($application->amount(), $breakpoints);
        return $this->roundingCalculator->roundUpToFive($application->amount(), $baseFee);
    }
}