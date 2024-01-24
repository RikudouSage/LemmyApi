<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CommentReport extends AbstractResponseDto
{
    public function __construct(
        public int $commentId,
        public int $creatorId,
        public int $id,
        public string $originalCommentText,
        public DateTimeInterface $published,
        public string $reason,
        public bool $resolved,
        public ?int $resolverId = null,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
