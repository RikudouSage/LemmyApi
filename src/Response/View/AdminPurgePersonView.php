<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\AdminPurgePerson;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class AdminPurgePersonView extends AbstractResponseDto
{
    public function __construct(
        public AdminPurgePerson $adminPurgePerson,
        public ?Person $admin = null,
    ) {
    }
}
