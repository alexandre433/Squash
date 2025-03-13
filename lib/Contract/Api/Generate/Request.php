<?php

namespace Squash\Contract\Api\Generate;

final class Request
{
    public const DEFAULT_STAY_ALIVE = '30s';

    public function __construct(
        public string  $address,
        public string  $prompt,
        public string  $model,
        public ?string $images = null,
        public ?string $format = null,
        public ?string $system = null,
        public ?string $template = null,
        public ?string $context = null,
        public bool    $raw = false,
        public string  $stayAlive = Request::DEFAULT_STAY_ALIVE
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'model'     => $this->model,
            'prompt'    => $this->prompt,
            'images'    => $this->images,
            'format'    => $this->format,
            'system'    => $this->system,
            'template'  => $this->template,
            'context'   => $this->context,
            'raw'       => $this->raw,
            'stayalive' => $this->stayAlive,
        ]);
    }
}
