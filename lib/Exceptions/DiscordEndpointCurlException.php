<?php

namespace Squash\Exceptions;

use Exception;

final class DiscordEndpointCurlException extends Exception
{
    public function __construct(
        string $curlError,
        string $message = 'Curl error: ',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message . $curlError, $code, $previous);
    }
}
