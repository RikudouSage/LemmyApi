<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class FederationState extends AbstractResponseDto
{
    public function __construct(
        public int $failCount,
        public int $instanceId,
        public ?DateTimeInterface $lastRetry = null,
        public ?int $lastSuccessfulId = null,
        public ?DateTimeInterface $lastSuccessfulPublishedTime = null,
        public ?DateTimeInterface $nextRetry = null,
    ) {
    }
}
