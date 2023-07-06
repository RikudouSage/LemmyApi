<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PersonAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $commentCount,
        public int $commentScore,
        public int $id,
        public int $personId,
        public int $postCount,
        public int $postScore,
    ) {
    }
}
