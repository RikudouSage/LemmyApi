<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModRemovePost extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public int $id,
        public int $modPersonId,
        public int $postId,
        public bool $removed,
        DateTimeInterface $when_,
        public ?string $reason = null,
    ) {
        $this->when = $when_;
    }
}
