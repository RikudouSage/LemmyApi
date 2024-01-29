<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use DateTimeInterface;
use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CommentAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $commentId,
        public int $score,
        public int $upvotes,
        public int $downvotes,
        public DateTimeInterface $published,
        public int $childCount,
        public float $hotRank,
        #[Since('0.19.0')]
        public ?int $controversyRank = null,
        #[Deprecated('0.19')]
        public ?int $id = null,
    ) {
    }
}
