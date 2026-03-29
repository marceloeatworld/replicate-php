<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class FileData
{
    /**
     * @param  array<string, string>|null  $checksums
     * @param  array<string, mixed>|null  $metadata
     * @param  array<string, string>|null  $urls
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $contentType,
        public readonly int $size,
        public readonly ?string $etag,
        public readonly ?array $checksums,
        public readonly ?array $metadata,
        public readonly string $createdAt,
        public readonly ?string $expiresAt,
        public readonly ?array $urls,
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
        $etag = $data['etag'] ?? null;
        $checksums = $data['checksums'] ?? null;
        $metadata = $data['metadata'] ?? null;
        $expiresAt = $data['expires_at'] ?? null;
        $urls = $data['urls'] ?? null;

        return new self(
            id: (string) ($data['id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            contentType: (string) ($data['content_type'] ?? ''),
            size: (int) ($data['size'] ?? 0),
            etag: is_string($etag) ? $etag : null,
            checksums: is_array($checksums) ? $checksums : null,
            metadata: is_array($metadata) ? $metadata : null,
            createdAt: (string) ($data['created_at'] ?? ''),
            expiresAt: is_string($expiresAt) ? $expiresAt : null,
            urls: is_array($urls) ? $urls : null,
        );
    }
}
