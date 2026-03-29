<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Requests\Files;

use MarceloEatWorld\Replicate\Data\FileData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasMultipartBody;

class PostFile extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $content  The file contents
     * @param  string  $filename  The filename
     * @param  string|null  $contentType  The MIME type
     * @param  array<string, mixed>|null  $metadata  Optional metadata
     */
    public function __construct(
        protected readonly string $content,
        protected readonly string $filename,
        protected readonly ?string $contentType = null,
        protected readonly ?array $metadata = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/files';
    }

    /**
     * @return array<int, MultipartValue>
     */
    protected function defaultBody(): array
    {
        $parts = [
            new MultipartValue(
                name: 'content',
                value: $this->content,
                filename: $this->filename,
                headers: $this->contentType ? ['Content-Type' => $this->contentType] : [],
            ),
        ];

        if ($this->metadata !== null) {
            $parts[] = new MultipartValue(
                name: 'metadata',
                value: json_encode($this->metadata, JSON_THROW_ON_ERROR),
            );
        }

        return $parts;
    }

    public function createDtoFromResponse(Response $response): FileData
    {
        return FileData::fromResponse($response);
    }
}
