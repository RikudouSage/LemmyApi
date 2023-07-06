<?php

namespace Rikudou\LemmyApi\Dto;

use Rikudou\LemmyApi\Response\Model\ImageFile;
use Rikudou\LemmyApi\Response\UploadImageResponse;

final readonly class UploadImageResult
{
    public bool $success;

    public ?string $deleteUrl;

    /**
     * @var array<ImageFile>|null
     */
    public ?array $files;

    public ?string $url;

    public function __construct(
        UploadImageResponse $response,
    ) {
        $this->success = $response->msg === 'ok';
        $this->deleteUrl = $response->deleteUrl;
        $this->files = $response->files;
        $this->url = $response->url;
    }
}
