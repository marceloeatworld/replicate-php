<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use MarceloEatWorld\Replicate\Data\ModelVersionData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetModelVersion extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
        protected readonly string $versionId,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s/versions/%s', $this->owner, $this->name, $this->versionId);
    }

    public function createDtoFromResponse(Response $response): ModelVersionData
    {
        return ModelVersionData::fromResponse($response);
    }
}
