<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\AdminPurgeComment;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class AdminPurgeCommentView extends AbstractResponseDto
{
    public function __construct(
        public AdminPurgeComment $adminPurgeComment,
        public Post $post,
        public ?Person $admin = null,
    ) {
    }
}
