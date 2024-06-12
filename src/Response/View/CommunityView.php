<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\SubscribedType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Aggregates\CommunityAggregates;
use Rikudou\LemmyApi\Response\Model\Community;

final readonly class CommunityView extends AbstractResponseDto
{
    public function __construct(
        public bool $blocked,
        public Community $community,
        public CommunityAggregates $counts,
        public SubscribedType $subscribed,
        #[Since('0.19.4')]
        public ?bool $bannedFromCommunity = null,
    ) {
    }
}
