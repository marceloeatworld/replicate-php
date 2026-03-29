<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class ModelData
{
    /**
     * @param  array<string, mixed>|null  $defaultExample
     * @param  array<string, mixed>|null  $latestVersion
     */
    public function __construct(
        public readonly string $url,
        public readonly string $owner,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $visibility,
        public readonly ?string $githubUrl,
        public readonly ?string $paperUrl,
        public readonly ?string $licenseUrl,
        public readonly int $runCount,
        public readonly ?string $coverImageUrl,
        public readonly ?array $defaultExample,
        public readonly ?array $latestVersion,
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
        $description = $data['description'] ?? null;
        $githubUrl = $data['github_url'] ?? null;
        $paperUrl = $data['paper_url'] ?? null;
        $licenseUrl = $data['license_url'] ?? null;
        $coverImageUrl = $data['cover_image_url'] ?? null;
        $defaultExample = $data['default_example'] ?? null;
        $latestVersion = $data['latest_version'] ?? null;

        return new self(
            url: (string) ($data['url'] ?? ''),
            owner: (string) ($data['owner'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            description: is_string($description) ? $description : null,
            visibility: (string) ($data['visibility'] ?? ''),
            githubUrl: is_string($githubUrl) ? $githubUrl : null,
            paperUrl: is_string($paperUrl) ? $paperUrl : null,
            licenseUrl: is_string($licenseUrl) ? $licenseUrl : null,
            runCount: (int) ($data['run_count'] ?? 0),
            coverImageUrl: is_string($coverImageUrl) ? $coverImageUrl : null,
            defaultExample: is_array($defaultExample) ? $defaultExample : null,
            latestVersion: is_array($latestVersion) ? $latestVersion : null,
        );
    }
}
