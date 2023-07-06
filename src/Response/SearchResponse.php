<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Enum\SearchType;
use Rikudou\LemmyApi\Response\View\CommentView;
use Rikudou\LemmyApi\Response\View\CommunityView;
use Rikudou\LemmyApi\Response\View\PersonView;
use Rikudou\LemmyApi\Response\View\PostView;

final readonly class SearchResponse extends AbstractResponseDto
{
    public SearchType $type;

    /**
     * @param array<CommentView> $comments
     * @param array<CommentView> $communities
     * @param array<PostView>    $posts
     * @param array<PersonView>  $users
     */
    public function __construct(
        #[ArrayType(CommentView::class)]
        public array $comments,
        #[ArrayType(CommunityView::class)]
        public array $communities,
        #[ArrayType(PostView::class)]
        public array $posts,
        #[ArrayType(PersonView::class)]
        public array $users,
        SearchType $type_,
    ) {
        $this->type = $type_;
    }
}
