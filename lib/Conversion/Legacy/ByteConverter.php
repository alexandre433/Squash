<?php

namespace Squash\Conversion\Legacy;

use OutOfRangeException;
use Squash\Conversion\Unit;
use Squash\Contract\ConverterInterface;
use SquashConversionsByte;

final class ByteConverter implements ConverterInterface
{
    private SquashConversionsByte $legacy;

    private Unit $from;

    private string $to;

    public function __construct(SquashConversionsByte $legacy)
    {
        $this->legacy = $legacy;
    }

    public function from(Unit $from): ConverterInterface
    {
        $converter = clone $this;
        $converter->from = $from;

        return $converter;
    }

    public function to(string $to): ConverterInterface
    {
        $converter = clone $this;
        $converter->to = $to;

        return $converter;
    }

    public function convert(): Unit
    {
        $result = match ($this->from->unit) {
            Unit::BYTE => $this->legacy->bytes($this->from->value, $this->to),
            Unit::KILOBYTE => $this->legacy->kilobytes($this->from->value, $this->to),
            Unit::MEGABYTE => $this->legacy->megabytes($this->from->value, $this->to),
            Unit::GIGABYTE => $this->legacy->gigabytes($this->from->value, $this->to),
            Unit::TERABYTE => $this->legacy->terabytes($this->from->value, $this->to),
            Unit::PETABYTE => $this->legacy->petabytes($this->from->value, $this->to),
            default => throw new OutOfRangeException('Unknown conversion unit.')
        };

        return new Unit($result, $this->to);
    }
}
