<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class LocalSiteUrlBlocklist extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public string $url,
        public DateTimeInterface $published,
        public ?DateTimeInterface $updated = null,
    ) {
    }
}
