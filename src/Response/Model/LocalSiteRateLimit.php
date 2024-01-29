<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class LocalSiteRateLimit extends AbstractResponseDto
{
    public function __construct(
        public int $comment,
        public int $commentPerSecond,
        public int $image,
        public int $imagePerSecond,
        public int $localSiteId,
        public int $message,
        public int $messagePerSecond,
        public int $post,
        public int $postPerSecond,
        public DateTimeInterface $published,
        public int $register,
        public int $registerPerSecond,
        public int $search,
        public int $searchPerSecond,
        public ?DateTimeInterface $updated = null,
        #[Since('0.19')]
        public ?int $importUserSettings = null,
        #[Since('0.19')]
        public ?int $importUserSettingsPerSecond = null,
        #[Deprecated('0.19')]
        public ?int $id = null,
    ) {
    }
}
