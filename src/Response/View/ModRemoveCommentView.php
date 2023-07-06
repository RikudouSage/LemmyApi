<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModRemoveComment;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class ModRemoveCommentView extends AbstractResponseDto
{
    public function __construct(
        public Comment $comment,
        public Person $commenter,
        public Community $community,
        public Post $post,
        public ModRemoveComment $modRemoveComment,
        public ?Person $moderator = null,
    ) {
    }
}
