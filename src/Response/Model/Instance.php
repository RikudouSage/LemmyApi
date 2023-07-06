<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Instance extends AbstractResponseDto
{
    public function __construct(
        public string $domain,
        public int $id,
        public DateTimeInterface $published,
        public ?string $software = null,
        public ?DateTimeInterface $updated = null,
        public ?string $version = null,
    ) {
    }
}
