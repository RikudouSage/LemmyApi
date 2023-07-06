<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\PrivateMessageReportView;

final readonly class ListPrivateMessageReportsResponse extends AbstractResponseDto
{
    /**
     * @param array<PrivateMessageReportView> $privateMessageReports
     */
    public function __construct(
        #[ArrayType(PrivateMessageReportView::class)]
        public array $privateMessageReports
    ) {
    }
}
