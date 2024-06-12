<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\ModlogActionType;
use Rikudou\LemmyApi\Enum\PostListingMode;
use Rikudou\LemmyApi\Enum\RegistrationMode;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\GetModlogResponse;
use Rikudou\LemmyApi\Response\GetSiteResponse;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\FederatedInstances;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\SiteMetadata;
use Rikudou\LemmyApi\Response\SiteResponse;

/**
 * createSite is intentionally not implemented, it doesn't make sense for an api client
 */
interface SiteEndpoint
{
    public function getSite(): GetSiteResponse;

    public function getMetadata(string $url): SiteMetadata;

    /**
     * @param array<string>|null $allowedInstances
     * @param array<string>|null $blockedInstances
     * @param array<string>|null $taglines
     * @param array<string>|null $blockedUrls
     */
    public function update(
        ?int $actorNameMaxLength = null,
        ?array $allowedInstances = null,
        ?bool $applicationEmailAdmins = null,
        ?string $applicationQuestion = null,
        ?string $banner = null,
        ?array $blockedInstances = null,
        ?string $captchaDifficulty = null,
        ?bool $captchaEnabled = null,
        ?bool $communityCreationAdminOnly = null,
        ?ListingType $defaultPostListingType = null,
        ?string $defaultTheme = null,
        ?string $description = null,
        ?string $discussionLanguages = null,
        ?bool $enableDownvotes = null,
        ?bool $enableNsfw = null,
        ?bool $federationDebug = null,
        ?bool $federationEnabled = null,
        ?int $federationWorkerCount = null,
        ?bool $hideModlogModNames = null,
        ?string $icon = null,
        ?string $legalInformation = null,
        ?string $name = null,
        ?bool $privateInstance = null,
        ?int $rateLimitComment = null,
        ?int $rateLimitCommentPerSecond = null,
        ?int $rateLimitImage = null,
        ?int $rateLimitImagePerSecond = null,
        ?int $rateLimitMessage = null,
        ?int $rateLimitMessagePerSecond = null,
        ?int $rateLimitPost = null,
        ?int $rateLimitPostPerSecond = null,
        ?int $rateLimitRegister = null,
        ?int $rateLimitRegisterPerSecond = null,
        ?int $rateLimitSearch = null,
        ?int $rateLimitSearchPerSecond = null,
        ?RegistrationMode $registrationMode = null,
        ?bool $reportsEmailAdmins = null,
        ?bool $requireEmailVerification = null,
        ?string $sidebar = null,
        ?string $slurFilterRegex = null,
        ?array $taglines = null,
        #[Since(version: '0.19.4')]
        ?PostListingMode $defaultPostListingMode = null,
        #[Since(version: '0.19.4')]
        ?SortType $defaultSortType = null,
        #[Since(version: '0.19.4')]
        ?array $blockedUrls = null,
    ): SiteResponse;

    public function getFederatedInstances(): FederatedInstances;

    public function getModlog(
        Community|int|null $community = null,
        ?int $limit = null,
        Person|int|null $moderator = null,
        Person|int|null $moddedUser = null,
        ?int $page = null,
        ?ModlogActionType $actionType = null,
    ): GetModlogResponse;
}
