<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use MarceloEatWorld\Replicate\Data\PredictionData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostModelPrediction extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $input
     * @param  array<string>|null  $webhookEventsFilter
     */
    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
        protected readonly array $input,
        protected readonly ?string $webhook = null,
        protected readonly ?array $webhookEventsFilter = null,
        protected readonly bool $stream = false,
        protected readonly ?int $wait = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s/predictions', $this->owner, $this->name);
    }

    protected function defaultHeaders(): array
    {
        $headers = [];

        if ($this->wait !== null) {
            $headers['Prefer'] = sprintf('wait=%d', $this->wait);
        }

        return $headers;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        $body = [
            'input' => $this->input,
        ];

        if ($this->webhook !== null) {
            $body['webhook'] = $this->webhook;
            $body['webhook_events_filter'] = $this->webhookEventsFilter;
        }

        if ($this->stream) {
            $body['stream'] = true;
        }

        return $body;
    }

    public function createDtoFromResponse(Response $response): PredictionData
    {
        return PredictionData::fromResponse($response);
    }
}
