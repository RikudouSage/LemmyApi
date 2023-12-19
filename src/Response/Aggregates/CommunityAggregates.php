<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use DateTimeInterface;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CommunityAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $comments,
        public int $communityId,
        public int $posts,
        public DateTimeInterface $published,
        public int $subscribers,
        public int $usersActiveDay,
        public int $usersActiveHalfYear,
        public int $usersActiveMonth,
        public int $usersActiveWeek,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?float $hotRank = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?int $id = null,
    ) {
    }
}
