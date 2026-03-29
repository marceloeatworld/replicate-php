<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Trainings;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class PostTrainingCancel extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/trainings/%s/cancel', $this->id);
    }
}
