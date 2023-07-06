<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class ModFeaturePost extends AbstractResponseDto
{
    public DateTimeInterface $when;

    public function __construct(
        public bool $featured,
        public int $id,
        public bool $isFeaturedCommunity,
        public int $modPersonId,
        public int $postId,
        DateTimeInterface $when_,
    ) {
        $this->when = $when_;
    }
}
