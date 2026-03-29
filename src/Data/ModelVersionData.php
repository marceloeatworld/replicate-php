<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class ModelVersionData
{
    /**
     * @param  array<string, mixed>|null  $openapiSchema
     */
    public function __construct(
        public readonly string $id,
        public readonly string $createdAt,
        public readonly ?string $cogVersion,
        public readonly ?array $openapiSchema,
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
        $cogVersion = $data['cog_version'] ?? null;
        $openapiSchema = $data['openapi_schema'] ?? null;

        return new self(
            id: (string) ($data['id'] ?? ''),
            createdAt: (string) ($data['created_at'] ?? ''),
            cogVersion: is_string($cogVersion) ? $cogVersion : null,
            openapiSchema: is_array($openapiSchema) ? $openapiSchema : null,
        );
    }
}
