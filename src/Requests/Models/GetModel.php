<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use MarceloEatWorld\Replicate\Data\ModelData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetModel extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s', $this->owner, $this->name);
    }

    public function createDtoFromResponse(Response $response): ModelData
    {
        return ModelData::fromResponse($response);
    }
}
