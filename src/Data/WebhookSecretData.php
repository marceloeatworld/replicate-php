<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class WebhookSecretData
{
    public function __construct(
        public readonly string $key,
    ) {}

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return new self(
            key: (string) ($data['key'] ?? ''),
        );
    }
}
