<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Deployments;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteDeployment extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/deployments/%s/%s', $this->owner, $this->name);
    }
}
