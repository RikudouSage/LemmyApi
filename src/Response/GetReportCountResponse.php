<?php

namespace Rikudou\LemmyApi\Response;

final readonly class GetReportCountResponse extends AbstractResponseDto
{
    public function __construct(
        public int $commentReports,
        public int $postReports,
        public ?int $communityId = null,
        public ?int $privateMessageReports = null,
    ) {
    }
}
