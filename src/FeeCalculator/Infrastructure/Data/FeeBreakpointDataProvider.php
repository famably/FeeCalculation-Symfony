<?php

namespace Lendable\Interview\FeeCalculator\Infrastructure\Data;

use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpoint;
use Lendable\Interview\FeeCalculator\Domain\Model\FeeBreakpointList;

final class FeeBreakpointDataProvider
{
    public function getForTerm(int $term): FeeBreakpointList
    {
        $breakpoints = match ($term) {
            12 => $this->get12MonthBreakpoints(),
            24 => $this->get24MonthBreakpoints(),
            default => throw new \InvalidArgumentException('Invalid term, must be 12 or 24 months')
        };

        return new FeeBreakpointList(...$breakpoints);
    }

    private function get12MonthBreakpoints(): array
    {
        return [
            new FeeBreakpoint(1000, 50),
            new FeeBreakpoint(2000, 90),
            new FeeBreakpoint(3000, 90),
            new FeeBreakpoint(4000, 115),
            new FeeBreakpoint(5000, 100),
            new FeeBreakpoint(6000, 120),
            new FeeBreakpoint(7000, 140),
            new FeeBreakpoint(8000, 160),
            new FeeBreakpoint(9000, 180),
            new FeeBreakpoint(10000, 200),
            new FeeBreakpoint(11000, 220),
            new FeeBreakpoint(12000, 240),
            new FeeBreakpoint(13000, 260),
            new FeeBreakpoint(14000, 280),
            new FeeBreakpoint(15000, 300),
            new FeeBreakpoint(16000, 320),
            new FeeBreakpoint(17000, 340),
            new FeeBreakpoint(18000, 360),
            new FeeBreakpoint(19000, 380),
            new FeeBreakpoint(20000, 400),
        ];
    }

    private function get24MonthBreakpoints(): array
    {
        return [
            new FeeBreakpoint(1000, 70),
            new FeeBreakpoint(2000, 100),
            new FeeBreakpoint(3000, 120),
            new FeeBreakpoint(4000, 160),
            new FeeBreakpoint(5000, 200),
            new FeeBreakpoint(6000, 240),
            new FeeBreakpoint(7000, 280),
            new FeeBreakpoint(8000, 320),
            new FeeBreakpoint(9000, 360),
            new FeeBreakpoint(10000, 400),
            new FeeBreakpoint(11000, 440),
            new FeeBreakpoint(12000, 480),
            new FeeBreakpoint(13000, 520),
            new FeeBreakpoint(14000, 560),
            new FeeBreakpoint(15000, 600),
            new FeeBreakpoint(16000, 640),
            new FeeBreakpoint(17000, 680),
            new FeeBreakpoint(18000, 720),
            new FeeBreakpoint(19000, 760),
            new FeeBreakpoint(20000, 800),
        ];
    }
}