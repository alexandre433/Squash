<?php

namespace Squash\Uuid;

use Squash\Contract\UuidInterface;

final class Uuid4 implements UuidInterface
{
    /**
     * Shamelessly stolen from {@link Legacy::generateUuid()}
     * TODO: Use {@link \Squash\Contract\RandomGeneratorInterface} to generate values.
     *
     * @return string
     */
    public function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
