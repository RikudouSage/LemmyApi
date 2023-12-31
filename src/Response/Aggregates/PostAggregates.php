<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use DateTimeInterface;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PostAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $comments,
        public int $downvotes,
        public int $postId,
        public DateTimeInterface $published,
        public int $score,
        public int $upvotes,
        #[Since('0.19.0')]
        public ?int $communityId = null,
        #[Since('0.19.0')]
        public ?int $creatorId = null,
        #[Since('0.19.0')]
        public ?float $controversyRank = null,
        #[Since('0.19.0')]
        public ?int $instanceId = null,
        #[Since('0.19.0')]
        public ?float $scaledRank = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?bool $featuredCommunity = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?bool $featuredLocal = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?float $hotRank = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?float $hotRankActive = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?int $id = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?DateTimeInterface $newestCommentTime = null,
        #[Since(version: '0.19.0', description: 'Lemmy devs clearly have no idea what a breaking change is.')]
        public ?DateTimeInterface $newestCommentTimeNecro = null,
    ) {
    }
}
