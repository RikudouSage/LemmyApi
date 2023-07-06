<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\PostReportView;

final readonly class ListPostReportsResponse extends AbstractResponseDto
{
    /**
     * @param array<PostReportView> $postReports
     */
    public function __construct(
        #[ArrayType(PostReportView::class)]
        public array $postReports,
    ) {
    }
}
