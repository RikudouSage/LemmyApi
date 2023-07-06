<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Aggregates\CommentAggregates;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\CommentReport;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class CommentReportView extends AbstractResponseDto
{
    public function __construct(
        public Comment $comment,
        public Person $commentCreator,
        public CommentReport $commentReport,
        public Community $community,
        public CommentAggregates $counts,
        public Person $creator,
        public bool $creatorBannedFromCommunity,
        public Post $post,
        public ?int $myVote = null,
        public ?Person $resolver = null,
    ) {
    }
}
