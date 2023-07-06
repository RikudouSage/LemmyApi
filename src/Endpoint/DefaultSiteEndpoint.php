<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\ModlogActionType;
use Rikudou\LemmyApi\Enum\RegistrationMode;
use Rikudou\LemmyApi\Response\GetFederatedInstancesResponse;
use Rikudou\LemmyApi\Response\GetModlogResponse;
use Rikudou\LemmyApi\Response\GetSiteMetadataResponse;
use Rikudou\LemmyApi\Response\GetSiteResponse;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\FederatedInstances;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\SiteMetadata;
use Rikudou\LemmyApi\Response\SiteResponse;

final readonly class DefaultSiteEndpoint extends AbstractEndpoint implements SiteEndpoint
{
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
    ): SiteResponse {
        $args = get_defined_vars();
        $bodyKeys = array_map(
            static fn (string $key) => (string) preg_replace_callback(
                '[A-Z]',
                static fn (array $matches) => '_' . strtolower($matches[1]),
                $key,
            ),
            array_keys($args),
        );
        $body = array_combine($bodyKeys, $args);

        return $this->defaultCall(
            '/site',
            HttpMethod::Put,
            $body,
            SiteResponse::class,
        );
    }

    public function getFederatedInstances(): FederatedInstances
    {
        return $this->defaultCall(
            '/federated_instances',
            HttpMethod::Get,
            [],
            GetFederatedInstancesResponse::class,
            static fn (GetFederatedInstancesResponse $response) => $response->federatedInstances,
        );
    }

    public function getModlog(
        Community|int|null $community = null,
        ?int $limit = null,
        int|Person|null $moderator = null,
        int|Person|null $moddedUser = null,
        ?int $page = null,
        ?ModlogActionType $actionType = null,
    ): GetModlogResponse {
        if ($community instanceof Community) {
            $community = $community->id;
        }
        if ($moderator instanceof Person) {
            $moderator = $moderator->id;
        }
        if ($moddedUser instanceof Person) {
            $moddedUser = $moddedUser->id;
        }

        return $this->defaultCall(
            '/modlog',
            HttpMethod::Get,
            [
                'community_id' => $community,
                'limit' => $limit,
                'mod_person_id' => $moderator,
                'other_person_id' => $moddedUser,
                'page' => $page,
                'type_' => $actionType?->value,
            ],
            GetModlogResponse::class,
        );
    }

    public function getSite(): GetSiteResponse
    {
        return $this->defaultCall(
            '/site',
            HttpMethod::Get,
            [],
            GetSiteResponse::class,
        );
    }

    public function getMetadata(string $url): SiteMetadata
    {
        return $this->defaultCall(
            '/post/site_metadata',
            HttpMethod::Get,
            [
                'url' => $url,
            ],
            GetSiteMetadataResponse::class,
            static fn (GetSiteMetadataResponse $response) => $response->metadata,
        );
    }
}
