<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Tagline extends AbstractResponseDto
{
    public function __construct(
        public string $content,
        public int $id,
        public int $localSiteId,
        public DateTimeInterface $published,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
