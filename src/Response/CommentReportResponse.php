<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\CommentReportView;

final readonly class CommentReportResponse extends AbstractResponseDto
{
    public function __construct(
        public CommentReportView $commentReportView,
    ) {
    }
}
