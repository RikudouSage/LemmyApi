<?php

namespace Rikudou\LemmyApi\Response\Model;

use DateTimeInterface;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\PostListingMode;
use Rikudou\LemmyApi\Enum\RegistrationMode;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class LocalSite extends AbstractResponseDto
{
    public function __construct(
        public int $actorNameMaxLength,
        public bool $applicationEmailAdmins,
        public string $captchaDifficulty,
        public bool $captchaEnabled,
        public bool $communityCreationAdminOnly,
        public ListingType $defaultPostListingType,
        public string $defaultTheme,
        public bool $enableDownvotes,
        public bool $enableNsfw,
        public bool $federationEnabled,
        public bool $hideModlogModNames,
        public int $id,
        public bool $privateInstance,
        public DateTimeInterface $published,
        public RegistrationMode $registrationMode,
        public bool $reportsEmailAdmins,
        public bool $requireEmailVerification,
        public int $siteId,
        public bool $siteSetup,
        public ?int $federationWorkerCount = null,
        public ?string $slurFilterRegex = null,
        public ?DateTimeInterface $updated = null,
        public ?string $legalInformation = null,
        public ?string $applicationQuestion = null,
        #[Since('0.19')]
        public ?bool $federationSignedFetch = null,
        #[Since('0.19.4')]
        public ?PostListingMode $defaultPostListingMode = null,
        #[Since('0.19.4')]
        public ?SortType $defaultSortType = null,
    ) {
    }
}
