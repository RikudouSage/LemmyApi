<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class SiteAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $comments,
        public int $communities,
        public int $id,
        public int $posts,
        public int $siteId,
        public int $users,
        public int $usersActiveDay,
        public int $usersActiveHalfYear,
        public int $usersActiveMonth,
        public int $usersActiveWeek,
    ) {
    }
}
