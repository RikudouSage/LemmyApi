<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommentView;
use Rikudou\LemmyApi\Response\View\CommunityModeratorView;
use Rikudou\LemmyApi\Response\View\PersonView;
use Rikudou\LemmyApi\Response\View\PostView;

final readonly class GetPersonDetailsResponse extends AbstractResponseDto
{
    /**
     * @param array<CommentView>            $comments
     * @param array<CommunityModeratorView> $moderates
     * @param array<PostView>               $posts
     */
    public function __construct(
        #[ArrayType(CommentView::class)]
        public array $comments,
        #[ArrayType(CommunityModeratorView::class)]
        public array $moderates,
        public PersonView $personView,
        #[ArrayType(PostView::class)]
        public array $posts,
    ) {
    }
}
