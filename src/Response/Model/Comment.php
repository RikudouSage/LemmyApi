<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Comment extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public int $creatorId,
        public int $postId,
        public string $content,
        public bool $removed,
        public DateTimeInterface $published,
        public bool $deleted,
        public string $apId,
        public bool $local,
        public string $path,
        public bool $distinguished,
        public Language $languageId,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
