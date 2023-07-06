<?php

namespace Rikudou\LemmyApi\Response;

final readonly class GetUnreadRegistrationApplicationCountResponse extends AbstractResponseDto
{
    public function __construct(
        public int $registrationApplications,
    ) {
    }
}
