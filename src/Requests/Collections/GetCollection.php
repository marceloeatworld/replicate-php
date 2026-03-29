<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Collections;

use MarceloEatWorld\Replicate\Data\CollectionData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCollection extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $slug,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/collections/%s', $this->slug);
    }

    public function createDtoFromResponse(Response $response): CollectionData
    {
        return CollectionData::fromResponse($response);
    }
}
