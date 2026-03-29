<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Deployments;

use MarceloEatWorld\Replicate\Data\DeploymentData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PatchDeployment extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
        protected readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/deployments/%s/%s', $this->owner, $this->name);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }

    public function createDtoFromResponse(Response $response): DeploymentData
    {
        return DeploymentData::fromResponse($response);
    }
}
