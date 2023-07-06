<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\ModAddCommunity;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class ModAddCommunityView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public ModAddCommunity $modAddCommunity,
        public Person $moddedPerson,
        public ?Person $moderator = null,
    ) {
    }
}
