<?php

namespace Rikudou\LemmyApi\Response\Model;

use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\PostListingMode;
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
        public string $interfaceLanguage,
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
        #[Deprecated(since: '0.19.0')]
        public ?string $totp2faUrl = null,
        public ?string $email = null,
        public ?bool $openLinksInNewTab = null,
        #[Since('0.19.0')]
        public ?bool $infiniteScrollEnabled = null,
        #[Since('0.19.0')]
        public ?bool $blurNsfw = null,
        #[Since('0.19.0')]
        public ?bool $autoExpand = null,
        #[Since('0.19.0')]
        public ?bool $admin = null,
        #[Since('0.19.0')]
        public ?PostListingMode $postListingMode = null,
        #[Since('0.19.0')]
        public ?bool $totp2faEnabled = null,
    ) {
    }
}
