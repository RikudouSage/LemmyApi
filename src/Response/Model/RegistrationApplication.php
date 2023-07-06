<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class RegistrationApplication extends AbstractResponseDto
{
    public function __construct(
        public string $answer,
        public int $id,
        public int $localUserId,
        public DateTimeInterface $published,
        public ?string $denyReason = null,
        public ?int $adminId = null,
    ) {
    }
}
