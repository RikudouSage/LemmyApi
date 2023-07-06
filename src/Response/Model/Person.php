<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use DateTimeInterface;

final readonly class Person extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $banned,
        public DateTimeInterface $published,
        public string $actorId,
        public bool $local,
        public bool $deleted,
        public bool $admin,
        public bool $botAccount,
        public int $instanceId,
        public ?string $avatar = null,
        public ?DateTimeInterface $banExpires = null,
        public ?string $banner = null,
        public ?string $bio = null,
        public ?string $displayName = null,
        public ?string $matrixUserId = null,
    ) {
    }
}
