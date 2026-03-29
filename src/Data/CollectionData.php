<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class CollectionData
{
    /**
     * @param  array<int, ModelData>  $models
     */
    public function __construct(
        public readonly string $slug,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $fullDescription,
        public readonly array $models,
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
        $fullDescription = $data['full_description'] ?? null;
        $rawModels = $data['models'] ?? [];

        $models = [];
        if (is_array($rawModels)) {
            foreach ($rawModels as $model) {
                if (is_array($model)) {
                    $models[] = ModelData::fromArray($model);
                }
            }
        }

        return new self(
            slug: (string) ($data['slug'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            fullDescription: is_string($fullDescription) ? $fullDescription : null,
            models: $models,
        );
    }
}
