<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Community extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $title,
        public bool $removed,
        public DateTimeInterface $published,
        public bool $deleted,
        public bool $nsfw,
        public string $actorId,
        public bool $local,
        public bool $hidden,
        public bool $postingRestrictedToMods,
        public int $instanceId,
        public ?string $description = null,
        public ?string $banner = null,
        public ?string $icon = null,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
