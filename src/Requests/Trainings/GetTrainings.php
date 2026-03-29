<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Trainings;

use MarceloEatWorld\Replicate\Data\TrainingsData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTrainings extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/trainings';
    }

    public function createDtoFromResponse(Response $response): TrainingsData
    {
        return TrainingsData::fromResponse($response);
    }
}
