<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PrivateMessageReport extends AbstractResponseDto
{
    public function __construct(
        public int $creatorId,
        public int $id,
        public string $originalPmText,
        public int $privateMessageId,
        public DateTimeInterface $published,
        public string $reason,
        public bool $resolved,
        public ?string $resolverId = null,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
