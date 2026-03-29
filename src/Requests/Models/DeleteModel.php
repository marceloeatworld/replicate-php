<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteModel extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s', $this->owner, $this->name);
    }
}
