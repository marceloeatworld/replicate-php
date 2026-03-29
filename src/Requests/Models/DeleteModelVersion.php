<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteModelVersion extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
        protected readonly string $versionId,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/models/%s/%s/versions/%s', $this->owner, $this->name, $this->versionId);
    }
}
