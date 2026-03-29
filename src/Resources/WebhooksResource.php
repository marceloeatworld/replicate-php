<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\WebhookSecretData;
use MarceloEatWorld\Replicate\Requests\Webhooks\GetWebhookSecret;
use Saloon\Http\BaseResource;

class WebhooksResource extends BaseResource
{
    public function getSecret(): WebhookSecretData
    {
        return WebhookSecretData::fromResponse($this->connector->send(new GetWebhookSecret));
    }
}
