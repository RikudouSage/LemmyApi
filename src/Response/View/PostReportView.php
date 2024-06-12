<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Aggregates\PostAggregates;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PostReport;

final readonly class PostReportView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public PostAggregates $counts,
        public Person $creator,
        public bool $creatorBannedFromCommunity,
        public Post $post,
        public Person $postCreator,
        public PostReport $postReport,
        public ?int $myVote = null,
        public ?Person $resolver = null,
        #[Since('0.19.4')]
        public ?bool $hidden = null,
    ) {
    }
}
