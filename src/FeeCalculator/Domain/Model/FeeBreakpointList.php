<?php

namespace Lendable\Interview\FeeCalculator\Domain\Model;

final class FeeBreakpointList implements \Countable, \IteratorAggregate
{
    /** @var array<FeeBreakpoint> */
    private array $breakpoints = [];

    public function __construct(FeeBreakpoint ...$breakpoints)
    {
        foreach ($breakpoints as $breakpoint) {
            $this->add($breakpoint);
        }
    }

    public function add(FeeBreakpoint $breakpoint): void
    {
        $this->breakpoints[] = $breakpoint;
    }

    public function get(int $index): FeeBreakpoint
    {
        if (!isset($this->breakpoints[$index])) {
            throw new \OutOfBoundsException('Breakpoint index out of bounds');
        }

        return $this->breakpoints[$index];
    }

    public function count(): int
    {
        return count($this->breakpoints);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->breakpoints);
    }

    public function isEmpty(): bool
    {
        return empty($this->breakpoints);
    }
}