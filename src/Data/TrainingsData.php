<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class TrainingsData
{
    /**
     * @param  array<int, TrainingData>  $results
     */
    public function __construct(
        public readonly ?string $previous,
        public readonly ?string $next,
        public readonly array $results,
    ) {}

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        $previous = $data['previous'] ?? null;
        $next = $data['next'] ?? null;
        $rawResults = $data['results'] ?? [];

        $results = [];
        if (is_array($rawResults)) {
            foreach ($rawResults as $item) {
                if (is_array($item)) {
                    $results[] = TrainingData::fromArray($item);
                }
            }
        }

        return new self(
            previous: is_string($previous) ? $previous : null,
            next: is_string($next) ? $next : null,
            results: $results,
        );
    }
}
