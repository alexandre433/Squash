<?php

namespace Squash\Conversion;

final class BiByteConverter extends Converter
{
    protected function getPositiveMutator(): callable
    {
        return fn (int $value) => (int) ($value * 1024);
    }

    protected function getNegativeMutator(): callable
    {
        return fn (int $value) => (int) ($value / 1024);
    }
}
