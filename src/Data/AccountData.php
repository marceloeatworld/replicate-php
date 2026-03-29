<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class AccountData
{
    public function __construct(
        public readonly string $type,
        public readonly string $username,
        public readonly string $name,
        public readonly string $githubUrl,
    ) {}

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return new self(
            type: (string) ($data['type'] ?? ''),
            username: (string) ($data['username'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            githubUrl: (string) ($data['github_url'] ?? ''),
        );
    }
}
