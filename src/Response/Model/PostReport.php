<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PostReport extends AbstractResponseDto
{
    public function __construct(
        public int $creatorId,
        public int $id,
        public string $originalPostName,
        public int $postId,
        public DateTimeInterface $published,
        public string $reason,
        public bool $resolved,
        public ?int $resolverId = null,
        public ?string $originalPostBody = null,
        public ?string $originalPostUrl = null,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
