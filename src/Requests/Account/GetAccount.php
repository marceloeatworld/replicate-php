<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Account;

use MarceloEatWorld\Replicate\Data\AccountData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetAccount extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/account';
    }

    public function createDtoFromResponse(Response $response): AccountData
    {
        return AccountData::fromResponse($response);
    }
}
