<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class LocalUser extends AbstractResponseDto
{
    public function __construct(
        public bool $acceptedApplication,
        public ListingType $defaultListingType,
        public SortType $defaultSortType,
        public bool $emailVerified,
        public int $id,
        public Language $interfaceLanguage,
        public int $personId,
        public bool $sendNotificationsToEmail,
        public bool $showAvatars,
        public bool $showBotAccounts,
        public bool $showNewPostNotifs,
        public bool $showNsfw,
        public bool $showReadPosts,
        public bool $showScores,
        public string $theme,
        public string $validatorTime,
        public ?string $totp2faUrl,
        public ?string $email = null,
    ) {
    }
}
