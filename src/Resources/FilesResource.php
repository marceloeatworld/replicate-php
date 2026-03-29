<?php

declare(strict_types=1);

namespace MarceloEatWorld\Replicate\Resources;

use MarceloEatWorld\Replicate\Data\FileData;
use MarceloEatWorld\Replicate\Data\FilesData;
use MarceloEatWorld\Replicate\Requests\Files\DeleteFile;
use MarceloEatWorld\Replicate\Requests\Files\GetFile;
use MarceloEatWorld\Replicate\Requests\Files\GetFiles;
use MarceloEatWorld\Replicate\Requests\Files\PostFile;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class FilesResource extends BaseResource
{
    public function list(?string $cursor = null): FilesData
    {
        $request = new GetFiles;

        if ($cursor !== null) {
            $request->query()->add('cursor', $cursor);
        }

        return FilesData::fromResponse($this->connector->send($request));
    }

    public function get(string $id): FileData
    {
        return FileData::fromResponse($this->connector->send(new GetFile($id)));
    }

    /**
     * @param  array<string, mixed>|null  $metadata
     */
    public function upload(
        string $content,
        string $filename,
        ?string $contentType = null,
        ?array $metadata = null,
    ): FileData {
        return FileData::fromResponse($this->connector->send(new PostFile(
            content: $content,
            filename: $filename,
            contentType: $contentType,
            metadata: $metadata,
        )));
    }

    public function delete(string $id): Response
    {
        return $this->connector->send(new DeleteFile($id));
    }
}
