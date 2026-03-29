<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\CollectionData;
use MarceloEatWorld\Replicate\Data\CollectionsData;
use MarceloEatWorld\Replicate\Requests\Collections\GetCollection;
use MarceloEatWorld\Replicate\Requests\Collections\GetCollections;
use Saloon\Http\BaseResource;

class CollectionsResource extends BaseResource
{
    public function list(?string $cursor = null): CollectionsData
    {
        $request = new GetCollections;

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return CollectionsData::fromResponse($this->connector->send($request));
    }

    public function get(string $slug): CollectionData
    {
        return CollectionData::fromResponse($this->connector->send(new GetCollection($slug)));
    }
}
