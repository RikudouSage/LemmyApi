<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PostReportView;

final readonly class PostReportResponse extends AbstractResponseDto
{
    public function __construct(
        public PostReportView $postReportView,
    ) {
    }
}
