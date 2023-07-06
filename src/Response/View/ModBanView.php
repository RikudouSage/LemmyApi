<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\ModBan;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class ModBanView extends AbstractResponseDto
{
    public function __construct(
        public Person $bannedPerson,
        public ModBan $modBan,
        public ?Person $moderator = null,
    ) {
    }
}
