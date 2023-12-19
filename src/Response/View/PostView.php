<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\SubscribedType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Aggregates\PostAggregates;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class PostView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public PostAggregates $counts,
        public Person $creator,
        public bool $creatorBannedFromCommunity,
        public bool $creatorBlocked,
        public Post $post,
        public bool $read,
        public bool $saved,
        public SubscribedType $subscribed,
        public int $unreadComments,
        public ?int $myVote = null,
        #[Since(version: '0.19.0')]
        public ?bool $creatorIsModerator = null,
        #[Since(version: '0.19.0')]
        public ?bool $creatorIsAdmin = null,
    ) {
    }
}
