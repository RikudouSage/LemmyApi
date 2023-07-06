<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModHideCommunity extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public int $communityId,
        public bool $hidden,
        public int $id,
        public int $modPersonId,
        DateTimeInterface $when_,
        public ?string $reason = null,
    ) {
        $this->when = $when_;
    }
}
