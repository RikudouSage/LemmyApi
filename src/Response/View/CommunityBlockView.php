<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class CommunityBlockView extends AbstractResponseDto
{
    public function __construct(
        public Community $community,
        public Person $person,
    ) {
    }
}
