<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class LocalSiteRateLimit extends AbstractResponseDto
{
    public function __construct(
        public int $comment,
        public int $commentPerSecond,
        public int $id,
        public int $image,
        public int $imagePerSecond,
        public int $localSiteId,
        public int $message,
        public int $messagePerSecond,
        public int $post,
        public int $postPerSecond,
        public DateTimeInterface $published,
        public int $register,
        public int $registerPerSecond,
        public int $search,
        public int $searchPerSecond,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
