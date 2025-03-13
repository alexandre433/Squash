<?php

namespace Squash\Exceptions;

use Exception;

final class OllamaEndpointCurlException extends Exception
{
    public function __construct(
        string $curlError,
        string $message = 'Failed to parse response from Ollama. CURL error: ',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message . $curlError, $code, $previous);
    }
}
