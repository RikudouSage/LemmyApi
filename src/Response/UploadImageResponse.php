<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\Model\ImageFile;

final readonly class UploadImageResponse extends AbstractResponseDto
{
    /**
     * @param array<ImageFile> $files
     */
    public function __construct(
        public string $msg,
        public ?string $deleteUrl = null,
        #[ArrayType(ImageFile::class)]
        public ?array $files = null,
        public ?string $url = null,
    ) {
    }
}
