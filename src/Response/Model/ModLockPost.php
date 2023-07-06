<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModLockPost extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public int $id,
        public bool $locked,
        public int $modPersonId,
        public int $postId,
        DateTimeInterface $when_,
    ) {
        $this->when = $when_;
    }
}
