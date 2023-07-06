<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommentView;

final readonly class GetCommentsResponse extends AbstractResponseDto
{
    /**
     * @param array<CommentView> $comments
     */
    public function __construct(
        #[ArrayType(CommentView::class)]
        public array $comments,
    ) {
    }
}
