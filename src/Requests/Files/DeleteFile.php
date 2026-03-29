<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Files;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteFile extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/files/%s', $this->id);
    }
}
