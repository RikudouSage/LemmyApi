<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\CommunityVisibility;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Site;
use Rikudou\LemmyApi\Response\View\CommunityView;

interface CommunityEndpoint
{
    public function get(int|string $nameOrId): CommunityView;

    /**
     * @return array<Language>
     */
    public function getLanguages(int|string|Community $community): array;

    public function getCommunityInstance(int|string|Community $community): ?Site;

    /**
     * @param array<Language>|null $languages
     */
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
    ): Community;

    public function delete(Community|int $community): bool;

    public function undelete(Community|int $community): bool;

    /**
     * @param array<Language>|null $languages
     */
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
    ): Community;

    /**
     * @return array<CommunityView>
     */
    public function list(
        ?int $limit = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?ListingType $listingType = null,
        ?bool $showNsfw = null,
    ): array;
}
