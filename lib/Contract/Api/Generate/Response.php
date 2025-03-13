<?php

namespace Squash\Contract\Api\Generate;

final class Response
{
    public function __construct(
        public string $createdAt,
        public int    $totalDuration,
        public int    $loadDuration,
        public int    $promptEvalCount,
        public int    $promptEvalDuration,
        public int    $evalCount,
        public int    $evalDuration,
        public array  $context,
        public string $response
    ) {
    }

}
