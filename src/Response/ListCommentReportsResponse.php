<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommentReportView;

final readonly class ListCommentReportsResponse extends AbstractResponseDto
{
    /**
     * @param array<CommentReportView> $commentReports
     */
    public function __construct(
        #[ArrayType(CommentReportView::class)]
        public array $commentReports,
    ) {
    }
}
