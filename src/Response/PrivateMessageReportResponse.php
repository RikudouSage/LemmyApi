<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PrivateMessageReportView;

final readonly class PrivateMessageReportResponse extends AbstractResponseDto
{
    public function __construct(
        public PrivateMessageReportView $privateMessageReportView,
    ) {
    }
}
