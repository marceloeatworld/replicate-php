<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use MarceloEatWorld\Replicate\Data\ModelVersionsData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetModelVersions extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s/versions', $this->owner, $this->name);
    }

    public function createDtoFromResponse(Response $response): ModelVersionsData
    {
        return ModelVersionsData::fromResponse($response);
    }
}
