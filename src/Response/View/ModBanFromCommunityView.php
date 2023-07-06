<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModBanFromCommunity;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class ModBanFromCommunityView extends AbstractResponseDto
{
    public function __construct(
        public Person $bannedPerson,
        public Community $community,
        public ModBanFromCommunity $modBanFromCommunity,
        public ?Person $moderator = null,
    ) {
    }
}
