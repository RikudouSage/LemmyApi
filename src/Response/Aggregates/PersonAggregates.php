<?php

namespace Rikudou\LemmyApi\Response\Aggregates;

use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class PersonAggregates extends AbstractResponseDto
{
    public function __construct(
        public int $commentCount,
        public int $personId,
        public int $postCount,
        #[Deprecated('0.19')]
        public ?int $commentScore = null,
        #[Deprecated('0.19')]
        public ?int $id = null,
        #[Deprecated('0.19')]
        public ?int $postScore = null,
    ) {
    }
}
