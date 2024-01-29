<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Aggregates\PersonAggregates;

final readonly class PersonView extends AbstractResponseDto
{
    public function __construct(
        public PersonAggregates $counts,
        public Person $person,
        #[Since('0.19')]
        public ?bool $isAdmin = null,
    ) {
    }
}
