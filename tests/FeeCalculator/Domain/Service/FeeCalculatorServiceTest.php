<?php

namespace Lendable\Interview\FeeCalculator\Domain\Service;

use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpoint;
use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpointList;
use Lendable\Interview\FeeCalculator\Domain\Model\LoanApplication;
use Lendable\Interview\FeeCalculator\Domain\Service\FeeCalculatorService;
use Lendable\Interview\FeeCalculator\Domain\Service\FeeInterpolator;
use Lendable\Interview\FeeCalculator\Domain\Service\RoundingCalculator;
use PHPUnit\Framework\TestCase;

class FeeCalculatorServiceTest extends TestCase
{
    private FeeCalculatorService $service;

    protected function setUp(): void
    {
        $this->service = new FeeCalculatorService(
            new FeeInterpolator(),
            new RoundingCalculator()
        );
    }

    public function testCalculateWithExactBreakpoint(): void
    {
        $application = new LoanApplication(1000, 12);
        $breakpoints = new FeeBreakpointList(new FeeBreakpoint(1000, 50));

        $fee = $this->service->calculate($application, $breakpoints);
        $this->assertEquals(50.0, $fee);
    }

    public function testCalculateWithInterpolation(): void
    {
        $application = new LoanApplication(1500, 12);
        $breakpoints = new FeeBreakpointList(
            new FeeBreakpoint(1000, 50),
            new FeeBreakpoint(2000, 90)
        );

        $fee = $this->service->calculate($application, $breakpoints);
        $this->assertEquals(70.0, $fee);
    }

    public function testCalculateWithRounding()
    {
        $application = new LoanApplication(1000, 12);
        $breakpoints = new FeeBreakpointList(new FeeBreakpoint(1000, 52));
        
        $fee = $this->service->calculate($application, $breakpoints);
        $this->assertEquals(55.0, $fee); // Changed from 53.0 to 55.0
    }
}