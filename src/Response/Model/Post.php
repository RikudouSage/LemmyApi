<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Post extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
        public int $creatorId,
        public int $communityId,
        public bool $removed,
        public bool $locked,
        public DateTimeInterface $published,
        public bool $deleted,
        public bool $nsfw,
        public string $apId,
        public bool $local,
        public Language $languageId,
        public bool $featuredCommunity,
        public bool $featuredLocal,
        public ?string $body = null,
        public ?string $embedDescription = null,
        public ?string $embedTitle = null,
        public ?string $embedVideoUrl = null,
        public ?string $thumbnailUrl = null,
        public ?DateTimeInterface $updated = null,
        public ?string $url = null,
    ) {
    }
}
