<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Trainings;

use MarceloEatWorld\Replicate\Data\TrainingData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostTraining extends Request implements HasBody
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
        protected readonly string $versionId,
        protected readonly string $destination,
        protected readonly array $input,
        protected readonly ?string $webhook = null,
        protected readonly ?array $webhookEventsFilter = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s/versions/%s/trainings', $this->owner, $this->name, $this->versionId);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        $body = [
            'destination' => $this->destination,
            'input' => $this->input,
        ];

        if ($this->webhook !== null) {
            $body['webhook'] = $this->webhook;
            $body['webhook_events_filter'] = $this->webhookEventsFilter;
        }

        return $body;
    }

    public function createDtoFromResponse(Response $response): TrainingData
    {
        return TrainingData::fromResponse($response);
    }
}
