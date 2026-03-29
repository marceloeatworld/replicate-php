<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Deployments;

use MarceloEatWorld\Replicate\Data\DeploymentsData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetDeployments extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/deployments';
    }

    public function createDtoFromResponse(Response $response): DeploymentsData
    {
        return DeploymentsData::fromResponse($response);
    }
}
