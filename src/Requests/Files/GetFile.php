<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Files;

use MarceloEatWorld\Replicate\Data\FileData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetFile extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/files/%s', $this->id);
    }

    public function createDtoFromResponse(Response $response): FileData
    {
        return FileData::fromResponse($response);
    }
}
