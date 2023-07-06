<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class PersonBlockView extends AbstractResponseDto
{
    public function __construct(
        public Person $person,
        public Person $target,
    ) {
    }
}
