<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PersonMention extends AbstractResponseDto
{
    public function __construct(
        public int $commentId,
        public int $id,
        public DateTimeInterface $published,
        public bool $read,
        public int $recipientId,
    ) {
    }
}
