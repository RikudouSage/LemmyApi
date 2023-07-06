<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\RegistrationApplicationView;

final readonly class ListRegistrationApplicationsResponse extends AbstractResponseDto
{
    /**
     * @param array<RegistrationApplicationView> $registrationApplications
     */
    public function __construct(
        #[ArrayType(RegistrationApplicationView::class)]
        public array $registrationApplications,
    ) {
    }
}
