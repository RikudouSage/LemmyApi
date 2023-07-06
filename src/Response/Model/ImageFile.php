<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ImageFile extends AbstractResponseDto
{
    public function __construct(
        public string $deleteToken,
        public string $file,
    ) {
    }
}
