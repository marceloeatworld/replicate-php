<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\PredictionData;
use MarceloEatWorld\Replicate\Data\PredictionsData;
use MarceloEatWorld\Replicate\Requests\Predictions\GetPrediction;
use MarceloEatWorld\Replicate\Requests\Predictions\GetPredictions;
use MarceloEatWorld\Replicate\Requests\Predictions\PostPrediction;
use MarceloEatWorld\Replicate\Requests\Predictions\PostPredictionCancel;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class PredictionsResource extends BaseResource
{
    public function list(?string $cursor = null): PredictionsData
    {
        $request = new GetPredictions;

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return PredictionsData::fromResponse($this->connector->send($request));
    }

    public function get(string $id): PredictionData
    {
        return PredictionData::fromResponse($this->connector->send(new GetPrediction($id)));
    }

    /**
     * @param  array<string, mixed>  $input
     * @param  array<string>|null  $webhookEventsFilter
     */
    public function create(
        string $version,
        array $input,
        ?string $webhook = null,
        ?array $webhookEventsFilter = null,
        bool $stream = false,
        ?int $wait = null,
    ): PredictionData {
        return PredictionData::fromResponse($this->connector->send(new PostPrediction(
            version: $version,
            input: $input,
            webhook: $webhook,
            webhookEventsFilter: $webhookEventsFilter,
            stream: $stream,
            wait: $wait,
        )));
    }

    public function cancel(string $id): Response
    {
        return $this->connector->send(new PostPredictionCancel($id));
    }
}
