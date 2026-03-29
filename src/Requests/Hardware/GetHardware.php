<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Hardware;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetHardware extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/hardware';
    }
}
