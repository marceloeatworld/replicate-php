<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Deployments;

use MarceloEatWorld\Replicate\Data\DeploymentData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostDeployment extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $name,
        protected readonly string $model,
        protected readonly string $version,
        protected readonly string $hardware,
        protected readonly int $minInstances,
        protected readonly int $maxInstances,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/deployments';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
            'model' => $this->model,
            'version' => $this->version,
            'hardware' => $this->hardware,
            'min_instances' => $this->minInstances,
            'max_instances' => $this->maxInstances,
        ];
    }

    public function createDtoFromResponse(Response $response): DeploymentData
    {
        return DeploymentData::fromResponse($response);
    }
}
