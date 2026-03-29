<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Webhooks;

use MarceloEatWorld\Replicate\Data\WebhookSecretData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetWebhookSecret extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/webhooks/default/secret';
    }

    public function createDtoFromResponse(Response $response): WebhookSecretData
    {
        return WebhookSecretData::fromResponse($response);
    }
}
