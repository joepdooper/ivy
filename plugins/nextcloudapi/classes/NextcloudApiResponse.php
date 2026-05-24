<?php

namespace NextcloudApi;

class NextcloudApiResponse
{
    public function __construct(
        public int $code,
        public ?string $version = null,
        public mixed $message = null,
        public mixed $meta = null,
        public mixed $data = null
    ) {}
}
