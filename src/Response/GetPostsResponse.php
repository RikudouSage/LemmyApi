<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\View\PostView;

final readonly class GetPostsResponse extends AbstractResponseDto
{
    /**
     * @param array<PostView> $posts
     */
    public function __construct(
        #[ArrayType(PostView::class)]
        public array $posts,
        #[Since('0.19.0')]
        public ?string $nextPage = null,
    ) {
    }
}
