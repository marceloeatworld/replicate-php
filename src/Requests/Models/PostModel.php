<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Models;

use MarceloEatWorld\Replicate\Data\ModelData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostModel extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $optional
     */
    public function __construct(
        protected readonly string $owner,
        protected readonly string $name,
        protected readonly string $hardware,
        protected readonly string $visibility,
        protected readonly array $optional = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/models';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_merge([
            'owner' => $this->owner,
            'name' => $this->name,
            'hardware' => $this->hardware,
            'visibility' => $this->visibility,
        ], $this->optional);
    }

    public function createDtoFromResponse(Response $response): ModelData
    {
        return ModelData::fromResponse($response);
    }
}
