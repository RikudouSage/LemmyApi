<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModRemoveCommunity;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class ModRemoveCommunityView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public ModRemoveCommunity $modRemoveCommunity,
        public ?Person $moderator = null,
    ) {
    }
}
