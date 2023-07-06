<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\CommentView;
use Rikudou\LemmyApi\Response\View\CommunityView;
use Rikudou\LemmyApi\Response\View\PersonView;
use Rikudou\LemmyApi\Response\View\PostView;

final readonly class ResolveObjectResponse extends AbstractResponseDto
{
    public function __construct(
        public ?CommentView $comment = null,
        public ?CommunityView $community = null,
        public ?PersonView $person = null,
        public ?PostView $post = null,
    ) {
    }
}
