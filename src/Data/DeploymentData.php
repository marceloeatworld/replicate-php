<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class DeploymentData
{
    /**
     * @param  array<string, mixed>|null  $currentRelease
     */
    public function __construct(
        public readonly string $owner,
        public readonly string $name,
        public readonly ?array $currentRelease,
    ) {}

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return self::fromArray($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $currentRelease = $data['current_release'] ?? null;

        return new self(
            owner: (string) ($data['owner'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            currentRelease: is_array($currentRelease) ? $currentRelease : null,
        );
    }
}
