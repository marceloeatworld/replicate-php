<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\ModelData;
use MarceloEatWorld\Replicate\Data\ModelsData;
use MarceloEatWorld\Replicate\Data\ModelVersionData;
use MarceloEatWorld\Replicate\Data\ModelVersionsData;
use MarceloEatWorld\Replicate\Data\PredictionData;
use MarceloEatWorld\Replicate\Requests\Models\DeleteModel;
use MarceloEatWorld\Replicate\Requests\Models\DeleteModelVersion;
use MarceloEatWorld\Replicate\Requests\Models\GetModel;
use MarceloEatWorld\Replicate\Requests\Models\GetModels;
use MarceloEatWorld\Replicate\Requests\Models\GetModelVersion;
use MarceloEatWorld\Replicate\Requests\Models\GetModelVersions;
use MarceloEatWorld\Replicate\Requests\Models\PatchModel;
use MarceloEatWorld\Replicate\Requests\Models\PostModel;
use MarceloEatWorld\Replicate\Requests\Models\PostModelPrediction;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class ModelsResource extends BaseResource
{
    public function list(?string $cursor = null): ModelsData
    {
        $request = new GetModels;

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return ModelsData::fromResponse($this->connector->send($request));
    }

    public function get(string $owner, string $name): ModelData
    {
        return ModelData::fromResponse($this->connector->send(new GetModel($owner, $name)));
    }

    /**
     * @param  array<string, mixed>  $optional  Optional fields: description, github_url, paper_url, license_url, cover_image_url
     */
    public function create(
        string $owner,
        string $name,
        string $hardware,
        string $visibility,
        array $optional = [],
    ): ModelData {
        return ModelData::fromResponse($this->connector->send(new PostModel(
            owner: $owner,
            name: $name,
            hardware: $hardware,
            visibility: $visibility,
            optional: $optional,
        )));
    }

    /**
     * @param  array<string, mixed>  $data  Fields to update: description, readme, github_url, paper_url, license_url, weights_url
     */
    public function update(string $owner, string $name, array $data): ModelData
    {
        return ModelData::fromResponse($this->connector->send(new PatchModel($owner, $name, $data)));
    }

    public function delete(string $owner, string $name): Response
    {
        return $this->connector->send(new DeleteModel($owner, $name));
    }

    /**
     * @param  array<string, mixed>  $input
     * @param  array<string>|null  $webhookEventsFilter
     */
    public function createPrediction(
        string $owner,
        string $name,
        array $input,
        ?string $webhook = null,
        ?array $webhookEventsFilter = null,
        bool $stream = false,
        ?int $wait = null,
    ): PredictionData {
        return PredictionData::fromResponse($this->connector->send(new PostModelPrediction(
            owner: $owner,
            name: $name,
            input: $input,
            webhook: $webhook,
            webhookEventsFilter: $webhookEventsFilter,
            stream: $stream,
            wait: $wait,
        )));
    }

    public function getVersion(string $owner, string $name, string $versionId): ModelVersionData
    {
        return ModelVersionData::fromResponse($this->connector->send(new GetModelVersion($owner, $name, $versionId)));
    }

    public function listVersions(string $owner, string $name, ?string $cursor = null): ModelVersionsData
    {
        $request = new GetModelVersions($owner, $name);

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return ModelVersionsData::fromResponse($this->connector->send($request));
    }

    public function deleteVersion(string $owner, string $name, string $versionId): Response
    {
        return $this->connector->send(new DeleteModelVersion($owner, $name, $versionId));
    }
}
