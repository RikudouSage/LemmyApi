<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModRemoveCommunity extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public int $communityId,
        public int $id,
        public int $modPersonId,
        public bool $removed,
        DateTimeInterface $when_,
        public ?string $reason = null,
        public ?DateTimeInterface $expires = null,
    ) {
        $this->when = $when_;
    }
}
