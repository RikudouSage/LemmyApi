<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\ModAdd;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class ModAddView extends AbstractResponseDto
{
    public function __construct(
        public ModAdd $modAdd,
        public Person $moddedPerson,
        public ?Person $moderator = null,
    ) {
    }
}
