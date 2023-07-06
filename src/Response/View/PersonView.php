<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Aggregates\PersonAggregates;

final readonly class PersonView extends AbstractResponseDto
{
    public function __construct(
        public PersonAggregates $counts,
        public Person $person,
    ) {
    }
}
