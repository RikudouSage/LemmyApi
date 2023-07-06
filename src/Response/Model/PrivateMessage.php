<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PrivateMessage extends AbstractResponseDto
{
    public function __construct(
        public string $apId,
        public string $content,
        public int $creatorId,
        public bool $deleted,
        public int $id,
        public bool $local,
        public DateTimeInterface $published,
        public bool $read,
        public int $recipientId,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
