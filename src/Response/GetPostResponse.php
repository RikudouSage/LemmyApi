<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommunityModeratorView;
use Rikudou\LemmyApi\Response\View\CommunityView;
use Rikudou\LemmyApi\Response\View\PostView;

final readonly class GetPostResponse extends AbstractResponseDto
{
    /**
     * @param array<PostView>               $crossPosts
     * @param array<CommunityModeratorView> $moderators
     */
    public function __construct(
        public CommunityView $communityView,
        #[ArrayType(PostView::class)]
        public array $crossPosts,
        #[ArrayType(CommunityModeratorView::class)]
        public array $moderators,
        public PostView $postView,
    ) {
    }
}
