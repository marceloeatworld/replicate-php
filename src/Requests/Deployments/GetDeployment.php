<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Deployments;

use MarceloEatWorld\Replicate\Data\DeploymentData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetDeployment extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/deployments/%s/%s', $this->owner, $this->name);
    }

    public function createDtoFromResponse(Response $response): DeploymentData
    {
        return DeploymentData::fromResponse($response);
    }
}
