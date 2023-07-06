<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CustomEmoji extends AbstractResponseDto
{
    public function __construct(
        public string $altText,
        public string $category,
        public int $id,
        public string $imageUrl,
        public int $localSiteId,
        public DateTimeInterface $published,
        public string $shortcode,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
