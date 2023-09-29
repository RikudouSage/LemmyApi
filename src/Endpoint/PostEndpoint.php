<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\PostFeatureType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\View\PostReportView;
use Rikudou\LemmyApi\Response\View\PostView;

interface PostEndpoint
{
    public function get(?int $postId = null, Comment|int|null $comment = null): PostView;

    /**
     * @return array<PostView>
     */
    public function getCrossPosts(Post|int $post): array;

    /**
     * @return array<PostView>
     *
     * @todo add support for cursor
     */
    public function getPosts(
        Community|int|string|null $community = null,
        ?int $limit = null,
        ?int $page = null,
        ?bool $savedOnly = null,
        ?SortType $sort = null,
        ?ListingType $listingType = null,
        #[Since('0.19.0')]
        ?bool $likedOnly = null,
        #[Since('0.19.0')]
        ?bool $dislikedOnly = null,
    ): array;

    public function create(
        Community|int $community,
        string $name,
        ?string $body = null,
        ?string $honeypot = null,
        ?Language $language = null,
        ?bool $nsfw = null,
        ?string $url = null,
    ): PostView;

    public function delete(Post|int $post): bool;

    public function undelete(Post|int $post): bool;

    public function update(
        Post|int $post,
        ?string $name = null,
        ?string $body = null,
        ?Language $language = null,
        ?bool $nsfw = null,
        ?string $url = null,
    ): PostView;

    public function report(Post|int $post, string $reason): PostReportView;

    public function pin(Post|int $post, PostFeatureType $featureType): bool;

    public function unpin(Post|int $post, PostFeatureType $featureType): bool;
}
