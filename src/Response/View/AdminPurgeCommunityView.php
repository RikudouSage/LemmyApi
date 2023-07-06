<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\AdminPurgeCommunity;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class AdminPurgeCommunityView extends AbstractResponseDto
{
    public function __construct(
        public AdminPurgeCommunity $adminPurgeCommunity,
        public ?Person $admin = null,
    ) {
    }
}
