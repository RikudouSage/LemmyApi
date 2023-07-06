<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModAdd extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public int $id,
        public int $modPersonId,
        public int $otherPersonId,
        public bool $removed,
        DateTimeInterface $when_
    ) {
        $this->when = $when_;
    }
}
