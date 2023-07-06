<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PostView;

final readonly class PostResponse extends AbstractResponseDto
{
    public function __construct(
        public PostView $postView,
    ) {
    }
}
