<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Trainings;

use MarceloEatWorld\Replicate\Data\TrainingData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTraining extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/trainings/%s', $this->id);
    }

    public function createDtoFromResponse(Response $response): TrainingData
    {
        return TrainingData::fromResponse($response);
    }
}
