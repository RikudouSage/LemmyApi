<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\CommunityResponse;
use Rikudou\LemmyApi\Response\GetCommunityResponse;
use Rikudou\LemmyApi\Response\ListCommunitiesResponse;
use Rikudou\LemmyApi\Response\Model\Community;

final readonly class DefaultCommunityEndpoint extends AbstractEndpoint implements CommunityEndpoint
{
    public function get(int|string $nameOrId): Community
    {
        return $this->defaultCall(
            '/community',
            HttpMethod::Get,
            [
                'id' => is_int($nameOrId) ? $nameOrId : null,
                'name' => is_string($nameOrId) ? $nameOrId : null,
            ],
            GetCommunityResponse::class,
            static fn (GetCommunityResponse $response) => $response->communityView->community,
        );
    }

    public function create(
        string $name,
        string $displayName,
        ?string $banner = null,
        ?string $description = null,
        ?array $languages = null,
        ?string $icon = null,
        ?bool $nsfw = null,
        ?bool $postingRestrictedToMods = null,
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
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community,
        );
    }

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

    public function update(
        Community|int $community,
        ?string $banner = null,
        ?string $description = null,
        ?array $languages = null,
        ?string $icon = null,
        ?bool $nsfw = null,
        ?bool $postingRestrictedToMods = null,
        ?string $displayName = null,
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
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community,
        );
    }

    public function list(
        ?int $limit = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?ListingType $listingType = null,
    ): array {
        return $this->defaultCall(
            '/community/list',
            HttpMethod::Get,
            [
                'limit' => $limit,
                'page' => $page,
                'sort' => $sort?->value,
                'type_' => $listingType?->value,
            ],
            ListCommunitiesResponse::class,
            static fn (ListCommunitiesResponse $response) => $response->communities,
        );
    }
}
