<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Data;

use Saloon\Http\Response;

final class TrainingData
{
    /**
     * @param  array<string, mixed>  $input
     * @param  array<string, mixed>|null  $output
     * @param  array<string, mixed>|null  $metrics
     * @param  array<string, string>  $urls
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $model,
        public readonly ?string $version,
        public readonly string $status,
        public readonly array $input,
        public readonly ?array $output,
        public readonly ?string $logs,
        public readonly mixed $error,
        public readonly ?array $metrics,
        public readonly string $createdAt,
        public readonly ?string $startedAt,
        public readonly ?string $completedAt,
        public readonly array $urls,
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
        $model = $data['model'] ?? null;
        $version = $data['version'] ?? null;
        $output = $data['output'] ?? null;
        $logs = $data['logs'] ?? null;
        $metrics = $data['metrics'] ?? null;
        $startedAt = $data['started_at'] ?? null;
        $completedAt = $data['completed_at'] ?? null;
        $urls = $data['urls'] ?? [];

        return new self(
            id: (string) ($data['id'] ?? ''),
            model: is_string($model) ? $model : null,
            version: is_string($version) ? $version : null,
            status: (string) ($data['status'] ?? ''),
            input: is_array($data['input'] ?? null) ? $data['input'] : [],
            output: is_array($output) ? $output : null,
            logs: is_string($logs) ? $logs : null,
            error: $data['error'] ?? null,
            metrics: is_array($metrics) ? $metrics : null,
            createdAt: (string) ($data['created_at'] ?? ''),
            startedAt: is_string($startedAt) ? $startedAt : null,
            completedAt: is_string($completedAt) ? $completedAt : null,
            urls: is_array($urls) ? $urls : [],
        );
    }
}
