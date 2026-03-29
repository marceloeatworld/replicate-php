<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\DeploymentData;
use MarceloEatWorld\Replicate\Data\DeploymentsData;
use MarceloEatWorld\Replicate\Data\PredictionData;
use MarceloEatWorld\Replicate\Requests\Deployments\DeleteDeployment;
use MarceloEatWorld\Replicate\Requests\Deployments\GetDeployment;
use MarceloEatWorld\Replicate\Requests\Deployments\GetDeployments;
use MarceloEatWorld\Replicate\Requests\Deployments\PatchDeployment;
use MarceloEatWorld\Replicate\Requests\Deployments\PostDeployment;
use MarceloEatWorld\Replicate\Requests\Deployments\PostDeploymentPrediction;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class DeploymentsResource extends BaseResource
{
    public function list(?string $cursor = null): DeploymentsData
    {
        $request = new GetDeployments;

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return DeploymentsData::fromResponse($this->connector->send($request));
    }

    public function get(string $owner, string $name): DeploymentData
    {
        return DeploymentData::fromResponse($this->connector->send(new GetDeployment($owner, $name)));
    }

    public function create(
        string $name,
        string $model,
        string $version,
        string $hardware,
        int $minInstances,
        int $maxInstances,
    ): DeploymentData {
        return DeploymentData::fromResponse($this->connector->send(new PostDeployment(
            name: $name,
            model: $model,
            version: $version,
            hardware: $hardware,
            minInstances: $minInstances,
            maxInstances: $maxInstances,
        )));
    }

    /**
     * @param  array<string, mixed>  $data  Fields to update: version, hardware, min_instances, max_instances
     */
    public function update(string $owner, string $name, array $data): DeploymentData
    {
        return DeploymentData::fromResponse($this->connector->send(new PatchDeployment($owner, $name, $data)));
    }

    public function delete(string $owner, string $name): Response
    {
        return $this->connector->send(new DeleteDeployment($owner, $name));
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
        return PredictionData::fromResponse($this->connector->send(new PostDeploymentPrediction(
            owner: $owner,
            name: $name,
            input: $input,
            webhook: $webhook,
            webhookEventsFilter: $webhookEventsFilter,
            stream: $stream,
            wait: $wait,
        )));
    }
}
