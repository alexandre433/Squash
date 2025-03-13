<?php

namespace Squash\Conversion;

final class ByteConverter extends Converter
{
    protected function getPositiveMutator(): callable
    {
        return fn (int $value) => (int) ($value * 1000);
    }

    protected function getNegativeMutator(): callable
    {
        return fn (int $value) => (int) ($value / 1000);
    }
}
