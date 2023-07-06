<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModRemovePost;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class ModRemovePostView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public Post $post,
        public ModRemovePost $modRemovePost,
        public ?Person $moderator = null,
    ) {
    }
}
