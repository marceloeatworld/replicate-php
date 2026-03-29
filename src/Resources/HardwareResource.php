<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\HardwareData;
use MarceloEatWorld\Replicate\Requests\Hardware\GetHardware;
use Saloon\Http\BaseResource;

class HardwareResource extends BaseResource
{
    /**
     * @return array<int, HardwareData>
     */
    public function list(): array
    {
        return HardwareData::collectionFromResponse(
            $this->connector->send(new GetHardware),
        );
    }
}
