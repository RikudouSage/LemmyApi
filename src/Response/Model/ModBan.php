<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModBan extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public bool $banned,
        public int $id,
        public int $modPersonId,
        public int $otherPersonId,
        DateTimeInterface $when_,
        public ?string $reason = null,
        public ?DateTimeInterface $expires = null,
    ) {
        $this->when = $when_;
    }
}
