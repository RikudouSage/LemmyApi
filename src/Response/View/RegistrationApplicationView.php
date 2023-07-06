<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\LocalUser;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\RegistrationApplication;

final readonly class RegistrationApplicationView extends AbstractResponseDto
{
    public function __construct(
        public Person $creator,
        public LocalUser $creatorLocalUser,
        public RegistrationApplication $registrationApplication,
        public ?Person $admin = null,
    ) {
    }
}
