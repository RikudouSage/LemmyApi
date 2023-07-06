<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\CommentReplyView;

final readonly class CommentReplyResponse extends AbstractResponseDto
{
    public function __construct(
        public CommentReplyView $commentReplyView,
    ) {
    }
}
