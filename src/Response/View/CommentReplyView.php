<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Enum\SubscribedType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Aggregates\CommentAggregates;
use Rikudou\LemmyApi\Response\Model\CommentReply;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class CommentReplyView extends AbstractResponseDto
{
    public function __construct(
        public Comment $comment,
        public CommentReply $commentReply,
        public Community $community,
        public CommentAggregates $counts,
        public Person $creator,
        public bool $creatorBannedFromCommunity,
        public bool $creatorBlocked,
        public Post $post,
        public Person $recipient,
        public bool $saved,
        public SubscribedType $subscribed,
        public ?int $myVote = null,
    ) {
    }
}
