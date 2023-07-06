<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CommunityAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $comments,
        public int $communityId,
        public int $hotRank,
        public int $id,
        public int $posts,
        public DateTimeInterface $published,
        public int $subscribers,
        public int $usersActiveDay,
        public int $usersActiveHalfYear,
        public int $usersActiveMonth,
        public int $usersActiveWeek,
    ) {
    }
}
