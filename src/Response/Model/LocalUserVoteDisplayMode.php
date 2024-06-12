<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

#[Since(version: '0.19.4')]
final readonly class LocalUserVoteDisplayMode extends AbstractResponseDto
{
    public function __construct(
        public int $localUserId,
        public bool $score,
        public bool $upvotes,
        public bool $downvotes,
        public bool $upvotePercentage,
    ) {
    }
}
