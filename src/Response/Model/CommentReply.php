<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CommentReply extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public int $recipientId,
        public int $commentId,
        public bool $read,
        public DateTimeInterface $published,
    ) {
    }
}
