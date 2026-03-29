<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Collections;

use MarceloEatWorld\Replicate\Data\CollectionsData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCollections extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/collections';
    }

    public function createDtoFromResponse(Response $response): CollectionsData
    {
        return CollectionsData::fromResponse($response);
    }
}
