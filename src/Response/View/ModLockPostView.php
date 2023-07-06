<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModLockPost;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class ModLockPostView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public ModLockPost $modLockPost,
        public Post $post,
        public ?Person $moderator = null,
    ) {
    }
}
