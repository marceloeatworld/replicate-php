<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use MarceloEatWorld\Replicate\Data\ModelsData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetModels extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/models';
    }

    public function createDtoFromResponse(Response $response): ModelsData
    {
        return ModelsData::fromResponse($response);
    }
}
