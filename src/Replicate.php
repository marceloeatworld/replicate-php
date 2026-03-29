<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate;

use MarceloEatWorld\Replicate\Resources\AccountResource;
use MarceloEatWorld\Replicate\Resources\CollectionsResource;
use MarceloEatWorld\Replicate\Resources\DeploymentsResource;
use MarceloEatWorld\Replicate\Resources\FilesResource;
use MarceloEatWorld\Replicate\Resources\HardwareResource;
use MarceloEatWorld\Replicate\Resources\ModelsResource;
use MarceloEatWorld\Replicate\Resources\PredictionsResource;
use MarceloEatWorld\Replicate\Resources\TrainingsResource;
use MarceloEatWorld\Replicate\Resources\WebhooksResource;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

final class Replicate extends Connector
{
    public function __construct(
        protected readonly string $apiToken,
    ) {}

    public function resolveBaseUrl(): string
    {
        return 'https://api.replicate.com/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiToken);
    }

    public function account(): AccountResource
    {
        return new AccountResource($this);
    }

    public function predictions(): PredictionsResource
    {
        return new PredictionsResource($this);
    }

    public function models(): ModelsResource
    {
        return new ModelsResource($this);
    }

    public function collections(): CollectionsResource
    {
        return new CollectionsResource($this);
    }

    public function deployments(): DeploymentsResource
    {
        return new DeploymentsResource($this);
    }

    public function trainings(): TrainingsResource
    {
        return new TrainingsResource($this);
    }

    public function files(): FilesResource
    {
        return new FilesResource($this);
    }

    public function hardware(): HardwareResource
    {
        return new HardwareResource($this);
    }

    public function webhooks(): WebhooksResource
    {
        return new WebhooksResource($this);
    }
}
