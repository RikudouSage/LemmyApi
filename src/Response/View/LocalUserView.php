<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Aggregates\PersonAggregates;
use Rikudou\LemmyApi\Response\Model\LocalUser;
use Rikudou\LemmyApi\Response\Model\LocalUserVoteDisplayMode;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class LocalUserView extends AbstractResponseDto
{
    public function __construct(
        public PersonAggregates $counts,
        public LocalUser $localUser,
        public Person $person,
        #[Since(version: '0.19.4')]
        public ?LocalUserVoteDisplayMode $localUserVoteDisplayMode = null,
    ) {
    }
}
