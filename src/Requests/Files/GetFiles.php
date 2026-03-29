<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Files;

use MarceloEatWorld\Replicate\Data\FilesData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetFiles extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/files';
    }

    public function createDtoFromResponse(Response $response): FilesData
    {
        return FilesData::fromResponse($response);
    }
}
