<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Predictions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class PostPredictionCancel extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/predictions/%s/cancel', $this->id);
    }
}
