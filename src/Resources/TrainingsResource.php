<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\TrainingData;
use MarceloEatWorld\Replicate\Data\TrainingsData;
use MarceloEatWorld\Replicate\Requests\Trainings\GetTraining;
use MarceloEatWorld\Replicate\Requests\Trainings\GetTrainings;
use MarceloEatWorld\Replicate\Requests\Trainings\PostTraining;
use MarceloEatWorld\Replicate\Requests\Trainings\PostTrainingCancel;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class TrainingsResource extends BaseResource
{
    public function list(?string $cursor = null): TrainingsData
    {
        $request = new GetTrainings;

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return TrainingsData::fromResponse($this->connector->send($request));
    }

    public function get(string $id): TrainingData
    {
        return TrainingData::fromResponse($this->connector->send(new GetTraining($id)));
    }

    /**
     * @param  array<string, mixed>  $input
     * @param  array<string>|null  $webhookEventsFilter
     */
    public function create(
        string $owner,
        string $name,
        string $versionId,
        string $destination,
        array $input,
        ?string $webhook = null,
        ?array $webhookEventsFilter = null,
    ): TrainingData {
        return TrainingData::fromResponse($this->connector->send(new PostTraining(
            owner: $owner,
            name: $name,
            versionId: $versionId,
            destination: $destination,
            input: $input,
            webhook: $webhook,
            webhookEventsFilter: $webhookEventsFilter,
        )));
    }

    public function cancel(string $id): Response
    {
        return $this->connector->send(new PostTrainingCancel($id));
    }
}
