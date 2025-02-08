<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\RequiresAuth;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\CommunityVisibility;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\CommunityResponse;
use Rikudou\LemmyApi\Response\GetCommunityResponse;
use Rikudou\LemmyApi\Response\ListCommunitiesResponse;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Site;
use Rikudou\LemmyApi\Response\View\CommunityView;

final readonly class DefaultCommunityEndpoint extends AbstractEndpoint implements CommunityEndpoint
{
    public function get(int|string $nameOrId): CommunityView
    {
        return $this->defaultCall(
            '/community',
            HttpMethod::Get,
            [
                'id' => is_int($nameOrId) ? $nameOrId : null,
                'name' => is_string($nameOrId) ? $nameOrId : null,
            ],
            GetCommunityResponse::class,
            static fn (GetCommunityResponse $response) => $response->communityView,
        );
    }

    public function getLanguages(Community|int|string $community): array
    {
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/community',
            HttpMethod::Get,
            [
                'id' => is_int($community) ? $community : null,
                'name' => is_string($community) ? $community : null,
            ],
            GetCommunityResponse::class,
            static fn (GetCommunityResponse $response) => $response->discussionLanguages,
        );
    }

    public function getCommunityInstance(Community|int|string $community): ?Site
    {
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/community',
            HttpMethod::Get,
            [
                'id' => is_int($community) ? $community : null,
                'name' => is_string($community) ? $community : null,
            ],
            GetCommunityResponse::class,
            static fn (GetCommunityResponse $response) => $response->site,
        );
    }

    #[RequiresAuth]
    public function create(
        string $name,
        string $displayName,
        ?string $banner = null,
        ?string $description = null,
        ?array $languages = null,
        ?string $icon = null,
        ?bool $nsfw = null,
        ?bool $postingRestrictedToMods = null,
        #[Since('0.19.4')]
        ?CommunityVisibility $visibility = null,
    ): Community {
        return $this->defaultCall(
            '/community',
            HttpMethod::Post,
            [
                'banner' => $banner,
                'description' => $description,
                'discussion_languages' => $languages === null
                    ? null
                    : array_map(static fn (Language $language) => $language->value, $languages),
                'icon' => $icon,
                'name' => $name,
                'nsfw' => $nsfw,
                'posting_restricted_to_mods' => $postingRestrictedToMods,
                'title' => $displayName,
                'visibility' => $visibility,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community,
        );
    }

    #[RequiresAuth]
    public function delete(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/delete',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'deleted' => true,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community->deleted,
        );
    }

    #[RequiresAuth]
    public function undelete(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/delete',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'deleted' => false,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => !$response->communityView->community->deleted,
        );
    }

    #[RequiresAuth]
    public function update(
        Community|int $community,
        ?string $banner = null,
        ?string $description = null,
        ?array $languages = null,
        ?string $icon = null,
        ?bool $nsfw = null,
        ?bool $postingRestrictedToMods = null,
        ?string $displayName = null,
        #[Since('0.19.4')]
        ?CommunityVisibility $visibility = null,
    ): Community {
        return $this->defaultCall(
            '/community',
            HttpMethod::Put,
            [
                'banner' => $banner,
                'community_id' => is_int($community) ? $community : $community->id,
                'description' => $description,
                'discussion_languages' => $languages === null
                    ? null
                    : array_map(static fn (Language $language) => $language->value, $languages),
                'icon' => $icon,
                'nsfw' => $nsfw,
                'posting_restricted_to_mods' => $postingRestrictedToMods,
                'title' => $displayName,
                'visibility' => $visibility,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community,
        );
    }

    #[RequiresAuth]
    public function list(
        ?int $limit = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?ListingType $listingType = null,
        ?bool $showNsfw = null,
    ): array {
        return $this->defaultCall(
            '/community/list',
            HttpMethod::Get,
            [
                'limit' => $limit,
                'page' => $page,
                'sort' => $sort?->value,
                'type_' => $listingType?->value,
                'show_nsfw' => $showNsfw,
            ],
            ListCommunitiesResponse::class,
            static fn (ListCommunitiesResponse $response) => $response->communities,
        );
    }

    public function hide(Community|int $community, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/community/hide',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'hidden' => true,
                'reason' => $reason,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community->deleted,
        );
    }

    public function unhide(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/hide',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'hidden' => false,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community->deleted,
        );
    }
}
