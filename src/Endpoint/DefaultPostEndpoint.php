<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\RequiresAuth;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\PostFeatureType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\GetPostResponse;
use Rikudou\LemmyApi\Response\GetPostsResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\PostReportResponse;
use Rikudou\LemmyApi\Response\PostResponse;
use Rikudou\LemmyApi\Response\View\PostReportView;
use Rikudou\LemmyApi\Response\View\PostView;

final readonly class DefaultPostEndpoint extends AbstractEndpoint implements PostEndpoint
{
    #[RequiresAuth]
    public function create(
        Community|int $community,
        string $name,
        ?string $body = null,
        ?string $honeypot = null,
        ?Language $language = null,
        ?bool $nsfw = null,
        ?string $url = null,
        #[Since('0.19.4')]
        ?string $customThumbnail = null,
        #[Since('0.19.4')]
        ?string $altText = null,
    ): PostView {
        return $this->defaultCall(
            '/post',
            HttpMethod::Post,
            [
                'body' => $body,
                'community_id' => is_int($community) ? $community : $community->id,
                'honeypot' => $honeypot,
                'language_id' => $language?->value,
                'name' => $name,
                'nsfw' => $nsfw,
                'url' => $url,
                'custom_thumbnail' => $customThumbnail,
                'alt_text' => $altText,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView,
        );
    }

    #[RequiresAuth]
    public function report(Post|int $post, string $reason): PostReportView
    {
        return $this->defaultCall(
            '/post/report',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'reason' => $reason,
            ],
            PostReportResponse::class,
            static fn (PostReportResponse $response) => $response->postReportView,
        );
    }

    #[RequiresAuth]
    public function delete(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/delete',
            HttpMethod::Post,
            [
                'deleted' => true,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->post->deleted,
        );
    }

    #[RequiresAuth]
    public function undelete(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/delete',
            HttpMethod::Post,
            [
                'deleted' => false,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => !$response->postView->post->deleted,
        );
    }

    #[RequiresAuth]
    public function update(
        Post|int $post,
        ?string $name = null,
        ?string $body = null,
        ?Language $language = null,
        ?bool $nsfw = null,
        ?string $url = null,
    ): PostView {
        return $this->defaultCall(
            '/post',
            HttpMethod::Put,
            [
                'body' => $body,
                'language_id' => $language?->value,
                'name' => $name,
                'nsfw' => $nsfw,
                'post_id' => is_int($post) ? $post : $post->id,
                'url' => $url,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView,
        );
    }

    #[RequiresAuth]
    public function pin(Post|int $post, PostFeatureType $featureType): bool
    {
        return $this->defaultCall(
            '/post/feature',
            HttpMethod::Post,
            [
                'feature_type' => $featureType->value,
                'featured' => true,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $featureType === PostFeatureType::Local
                ? $response->postView->post->featuredLocal
                : $response->postView->post->featuredCommunity,
        );
    }

    #[RequiresAuth]
    public function unpin(Post|int $post, PostFeatureType $featureType): bool
    {
        return $this->defaultCall(
            '/post/feature',
            HttpMethod::Post,
            [
                'feature_type' => $featureType->value,
                'featured' => false,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $featureType === PostFeatureType::Local
                ? !$response->postView->post->featuredLocal
                : !$response->postView->post->featuredCommunity,
        );
    }

    public function get(?int $postId = null, int|Comment|null $comment = null): PostView
    {
        if ($comment instanceof Comment) {
            $comment = $comment->id;
        }

        return $this->defaultCall(
            '/post',
            HttpMethod::Get,
            [
                'id' => $postId,
                'comment_id' => $comment,
            ],
            GetPostResponse::class,
            static fn (GetPostResponse $response) => $response->postView,
        );
    }

    public function getCrossPosts(Post|int $post): array
    {
        return $this->defaultCall(
            '/post',
            HttpMethod::Get,
            [
                'id' => is_int($post) ? $post : $post->id,
            ],
            GetPostResponse::class,
            static fn (GetPostResponse $response) => $response->crossPosts,
        );
    }

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
    ): array {
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/post/list',
            HttpMethod::Get,
            [
                'community_id' => is_int($community) ? $community : null,
                'community_name' => is_string($community) ? $community : null,
                'limit' => $limit,
                'page' => $page,
                'saved_only' => $savedOnly,
                'sort' => $sort?->value,
                'type_' => $listingType?->value,
                'liked_only' => $likedOnly,
                'disliked_only' => $dislikedOnly,
            ],
            GetPostsResponse::class,
            static fn (GetPostsResponse $response) => $response->posts,
        );
    }
}
