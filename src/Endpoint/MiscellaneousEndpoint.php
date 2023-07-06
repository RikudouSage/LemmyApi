<?php

namespace Rikudou\LemmyApi\Endpoint;

use Psr\Http\Message\StreamInterface;
use Rikudou\LemmyApi\Dto\UploadImageResult;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SearchType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\ResolveObjectResponse;
use Rikudou\LemmyApi\Response\SearchResponse;
use SplFileInfo;

interface MiscellaneousEndpoint
{
    public function resolveObject(string $query): ResolveObjectResponse;

    public function search(
        string $query,
        Community|int|string|null $community = null,
        Person|int|null $creator = null,
        ?int $limit = null,
        ?ListingType $listingType = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?SearchType $searchType = null,
    ): SearchResponse;

    public function uploadImage(StreamInterface|SplFileInfo $image, ?string $filename = null): UploadImageResult;
}
