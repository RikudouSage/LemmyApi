<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Site extends AbstractResponseDto
{
    public function __construct(
        public string $actorId,
        public int $id,
        public string $inboxUrl,
        public int $instanceId,
        public DateTimeInterface $lastRefreshedAt,
        public string $name,
        public string $publicKey,
        public DateTimeInterface $published,
        public ?string $sidebar = null,
        public ?string $privateKey = null,
        public ?string $banner = null,
        public ?string $description = null,
        public ?string $icon = null,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
