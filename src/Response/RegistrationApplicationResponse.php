<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\RegistrationApplicationView;

final readonly class RegistrationApplicationResponse extends AbstractResponseDto
{
    public function __construct(
        public RegistrationApplicationView $registrationApplicationView,
    ) {
    }
}
