<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class AdminPurgePerson extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public int $adminPersonId,
        public int $id,
        DateTimeInterface $when_,
        public ?string $reason = null,
    ) {
        $this->when = $when_;
    }
}
