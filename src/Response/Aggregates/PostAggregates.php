<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PostAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $comments,
        public int $downvotes,
        public bool $featuredCommunity,
        public bool $featuredLocal,
        public int $hotRank,
        public int $hotRankActive,
        public int $id,
        public DateTimeInterface $newestCommentTime,
        public DateTimeInterface $newestCommentTimeNecro,
        public int $postId,
        public DateTimeInterface $published,
        public int $score,
        public int $upvotes,
        public ?int $communityId = null,
    ) {
    }
}
