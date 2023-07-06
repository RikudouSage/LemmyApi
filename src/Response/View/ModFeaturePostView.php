<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModFeaturePost;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;

final readonly class ModFeaturePostView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public ModFeaturePost $modFeaturePost,
        public Post $post,
        public ?Person $moderator = null,
    ) {
    }
}
