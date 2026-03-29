<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\AccountData;
use MarceloEatWorld\Replicate\Requests\Account\GetAccount;
use Saloon\Http\BaseResource;

class AccountResource extends BaseResource
{
    public function get(): AccountData
    {
        $response = $this->connector->send(new GetAccount);

        return AccountData::fromResponse($response);
    }
}
