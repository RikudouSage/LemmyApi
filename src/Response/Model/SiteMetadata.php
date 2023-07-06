<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class SiteMetadata extends AbstractResponseDto
{
    public function __construct(
        public ?string $description = null,
        public ?string $embedVideoUrl = null,
        public ?string $image = null,
        public ?string $title = null,
    ) {
    }
}
