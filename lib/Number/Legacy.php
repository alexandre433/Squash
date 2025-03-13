<?php

namespace Squash\Number;

use InvalidArgumentException;
use Squash\Contract\CalculatorInterface;
use Squash\Contract\NumberFormatterInterface;
use SquashNumber;

final class Legacy implements NumberFormatterInterface, CalculatorInterface
{
    private SquashNumber $legacy;

    public function __construct(SquashNumber $legacy)
    {
        $this->legacy = $legacy;
    }

    /**
     * Legacy follows some questionable logic. You can get `2 - 3 = 1`.
     *
     * @param ...$arguments
     *
     * @return float|int|void
     */
    public function calculate(...$arguments)
    {
        if (count($arguments) != 3) {
            throw new InvalidArgumentException('Argument count must be exactly three.');
        }

        [$left, $operator, $right] = $arguments;

        return match ($operator) {
            '+' => $this->legacy->add($left, $right),
            '-' => $this->legacy->subtract($left, $right),
            '*' => $this->legacy->multiply($left, $right),
            '/' => $this->legacy->divide($left, $right),
            default => throw new InvalidArgumentException('Unknown operator.'),
        };
    }

    public function format(float $number): string
    {
        return $this->legacy->format($number);
    }

    public function round(float $number, int $decimals): string
    {
        return $this->legacy->round($number, $decimals);
    }
}
