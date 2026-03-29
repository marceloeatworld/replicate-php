<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class HardwareData
{
    public function __construct(
        public readonly string $name,
        public readonly string $sku,
    ) {}

    /**
     * @return array<int, self>
     */
    public static function collectionFromResponse(Response $response): array
    {
        $data = $response->json();

        $results = [];
        foreach ($data as $item) {
            if (is_array($item)) {
                $results[] = new self(
                    name: (string) ($item['name'] ?? ''),
                    sku: (string) ($item['sku'] ?? ''),
                );
            }
        }

        return $results;
    }
}
