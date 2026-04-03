# Replicate PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marceloeatworld/replicate-php.svg?style=flat-square)](https://packagist.org/packages/marceloeatworld/replicate-php)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/marceloeatworld/replicate-php/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/marceloeatworld/replicate-php/actions?query=workflow%3Atests+branch%3Amain)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/marceloeatworld/replicate-php/formats.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/marceloeatworld/replicate-php/actions?query=workflow%3Aformats+branch%3Amain)

A framework-agnostic PHP client for the [Replicate API](https://replicate.com/) compatible with Laravel and native PHP, built on [Saloon v4](https://docs.saloon.dev/).

Full coverage of the Replicate HTTP API: predictions, models, deployments, trainings, files, collections, hardware, webhooks, and account.

> This package is a fork of [benbjurstrom/replicate-php](https://github.com/benbjurstrom/replicate-php) which only covered predictions. This version has been entirely rewritten with full API coverage, Saloon v4, PHP 8.2+, and typed DTOs for every endpoint.

## Requirements

- PHP 8.2+

## Installation

```bash
composer require marceloeatworld/replicate-php
```

## Quick Start

```php
use MarceloEatWorld\Replicate\Replicate;

$replicate = new Replicate(
    apiToken: $_ENV['REPLICATE_API_TOKEN'],
);
```

### Create a prediction

```php
$prediction = $replicate->predictions()->create(
    version: 'stability-ai/sdxl:c221b2b8ef527988fb59bf24a8b97c4561f1c671f73bd389f866bfb27c061316',
    input: ['prompt' => 'a photo of an astronaut riding a horse on mars'],
);

$prediction->id;     // "xyz123"
$prediction->status; // "starting"
```

### Create a prediction using an official model

```php
$prediction = $replicate->models()->createPrediction(
    owner: 'meta',
    name: 'meta-llama-3-70b-instruct',
    input: ['prompt' => 'Write a haiku about PHP'],
);
```

### Synchronous predictions (wait for result)

```php
$prediction = $replicate->predictions()->create(
    version: 'stability-ai/sdxl:c221b2b8ef527988fb59bf24a8b97c4561f1c671f73bd389f866bfb27c061316',
    input: ['prompt' => 'a painting of a cat'],
    wait: 60, // wait up to 60 seconds for completion
);

if ($prediction->status === 'succeeded') {
    $prediction->output; // result is ready
}
```

### Get prediction status

```php
$prediction = $replicate->predictions()->get('xyz123');
$prediction->status; // "succeeded"
$prediction->output; // ["https://replicate.delivery/..."]
```

### List predictions

```php
$list = $replicate->predictions()->list();
$list->results; // array of PredictionData
$list->next;    // cursor for next page

// Paginate
$nextPage = $replicate->predictions()->list(cursor: $list->next);
```

### Cancel a prediction

```php
$replicate->predictions()->cancel('xyz123');
```

## Webhooks

Pass webhook parameters directly to creation methods:

```php
$prediction = $replicate->predictions()->create(
    version: 'owner/model:version',
    input: ['prompt' => 'hello'],
    webhook: 'https://example.com/webhook',
    webhookEventsFilter: ['completed'],
);
```

Get the webhook signing secret for verification:

```php
$secret = $replicate->webhooks()->getSecret();
$secret->key; // "whsec_..."
```

## Streaming

```php
$prediction = $replicate->predictions()->create(
    version: 'owner/model:version',
    input: ['prompt' => 'hello'],
    stream: true,
);

// If the model supports streaming, use the stream URL
$prediction->urls['stream']; // SSE endpoint URL
```

## Models

```php
// List public models
$models = $replicate->models()->list();

// Get a model
$model = $replicate->models()->get('stability-ai', 'sdxl');

// Create a model
$model = $replicate->models()->create(
    owner: 'your-username',
    name: 'my-model',
    hardware: 'gpu-a40-large',
    visibility: 'private',
);

// Update a model
$model = $replicate->models()->update('your-username', 'my-model', [
    'description' => 'Updated description',
]);

// Delete a model (must be private, no versions)
$replicate->models()->delete('your-username', 'my-model');
```

### Model Versions

```php
$versions = $replicate->models()->listVersions('stability-ai', 'sdxl');
$version = $replicate->models()->getVersion('stability-ai', 'sdxl', 'abc123');
$replicate->models()->deleteVersion('your-username', 'my-model', 'abc123');
```

## Deployments

```php
// List deployments
$deployments = $replicate->deployments()->list();

// Get a deployment
$deployment = $replicate->deployments()->get('your-username', 'my-deployment');

// Create a deployment
$deployment = $replicate->deployments()->create(
    name: 'my-deployment',
    model: 'your-username/my-model',
    version: 'abc123...',
    hardware: 'gpu-a40-large',
    minInstances: 1,
    maxInstances: 3,
);

// Update a deployment
$deployment = $replicate->deployments()->update('your-username', 'my-deployment', [
    'min_instances' => 2,
    'max_instances' => 5,
]);

// Create prediction on a deployment
$prediction = $replicate->deployments()->createPrediction(
    owner: 'your-username',
    name: 'my-deployment',
    input: ['prompt' => 'hello world'],
);

// Delete a deployment
$replicate->deployments()->delete('your-username', 'my-deployment');
```

## Trainings

```php
// Create a training
$training = $replicate->trainings()->create(
    owner: 'stability-ai',
    name: 'sdxl',
    versionId: 'abc123...',
    destination: 'your-username/my-trained-model',
    input: ['train_data' => 'https://example.com/data.zip'],
    webhook: 'https://example.com/training-done',
);

// Get training status
$training = $replicate->trainings()->get($training->id);

// List trainings
$trainings = $replicate->trainings()->list();

// Cancel a training
$replicate->trainings()->cancel($training->id);
```

## Files

```php
// Upload a file
$file = $replicate->files()->upload(
    content: file_get_contents('/path/to/image.jpg'),
    filename: 'image.jpg',
    contentType: 'image/jpeg',
);

// Get file metadata
$file = $replicate->files()->get($file->id);

// List files
$files = $replicate->files()->list();

// Delete a file
$replicate->files()->delete($file->id);
```

## Collections

```php
// List collections
$collections = $replicate->collections()->list();

// Get a collection with its models
$collection = $replicate->collections()->get('text-to-image');
$collection->models; // array of ModelData
```

## Hardware

```php
// List available hardware
$hardware = $replicate->hardware()->list();
// Returns array of HardwareData with name and sku
```

## Account

```php
$account = $replicate->account()->get();
$account->username;
$account->type; // "user" or "organization"
```

## Using with Laravel

Add your credentials to your services config:

```php
// config/services.php
'replicate' => [
    'api_token' => env('REPLICATE_API_TOKEN'),
],
```

Bind in a service provider:

```php
// app/Providers/AppServiceProvider.php
public function register(): void
{
    $this->app->bind(Replicate::class, fn () => new Replicate(
        apiToken: config('services.replicate.api_token'),
    ));
}
```

Use anywhere:

```php
$prediction = app(Replicate::class)->predictions()->get($id);
```

## Testing

Use Saloon's built-in mocking:

```php
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use MarceloEatWorld\Replicate\Requests\Predictions\GetPrediction;

$mockClient = new MockClient([
    GetPrediction::class => MockResponse::make(['id' => 'xyz', 'status' => 'succeeded']),
]);

$replicate = new Replicate('test-token');
$replicate->withMockClient($mockClient);

$prediction = $replicate->predictions()->get('xyz');
$prediction->status; // "succeeded"
```

## Response Data

All responses are returned as typed data objects:

| DTO | Description |
|-----|-------------|
| `AccountData` | Account info |
| `PredictionData` | Single prediction |
| `PredictionsData` | Paginated prediction list |
| `ModelData` | Single model |
| `ModelsData` | Paginated model list |
| `ModelVersionData` | Single model version |
| `ModelVersionsData` | Paginated version list |
| `CollectionData` | Single collection with models |
| `CollectionsData` | Paginated collection list |
| `DeploymentData` | Single deployment |
| `DeploymentsData` | Paginated deployment list |
| `TrainingData` | Single training |
| `TrainingsData` | Paginated training list |
| `FileData` | Single file metadata |
| `FilesData` | Paginated file list |
| `HardwareData` | Hardware option (name + SKU) |
| `WebhookSecretData` | Webhook signing secret |

## Credits

- [Marcelo Pereira](https://github.com/marceloeatworld)
- Originally forked from [benbjurstrom/replicate-php](https://github.com/benbjurstrom/replicate-php)

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.
