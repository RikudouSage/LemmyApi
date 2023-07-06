<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommentReplyView;

final readonly class GetRepliesResponse extends AbstractResponseDto
{
    /**
     * @param array<CommentReplyView> $replies
     */
    public function __construct(
        #[ArrayType(CommentReplyView::class)]
        public array $replies,
    ) {
    }
}
