<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\RequiresAuth;
use Rikudou\LemmyApi\Enum\CommentSortType;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Response\CommentReportResponse;
use Rikudou\LemmyApi\Response\CommentResponse;
use Rikudou\LemmyApi\Response\GetCommentsResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\View\CommentReportView;
use Rikudou\LemmyApi\Response\View\CommentView;

final readonly class DefaultCommentEndpoint extends AbstractEndpoint implements CommentEndpoint
{
    #[RequiresAuth]
    public function create(
        Post|int $post,
        string $content,
        ?string $formId = null,
        ?Language $language = null,
        Comment|int|null $parent = null,
    ): CommentView {
        if ($parent instanceof Comment) {
            $parent = $parent->id;
        }

        return $this->defaultCall(
            '/comment',
            HttpMethod::Post,
            [
                'content' => $content,
                'form_id' => $formId,
                'language_id' => $language?->value,
                'parent_id' => $parent,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView,
        );
    }

    #[RequiresAuth]
    public function report(int|Comment $comment, string $reason): CommentReportView
    {
        return $this->defaultCall(
            '/comment/report',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'reason' => $reason,
            ],
            CommentReportResponse::class,
            static fn (CommentReportResponse $response) => $response->commentReportView,
        );
    }

    #[RequiresAuth]
    public function delete(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/delete',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'deleted' => true,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView->comment->deleted,
        );
    }

    #[RequiresAuth]
    public function undelete(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/delete',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'deleted' => false,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => !$response->commentView->comment->deleted,
        );
    }

    #[RequiresAuth]
    public function update(
        int|Comment $comment,
        ?string $content = null,
        ?string $formId = null,
        ?Language $language = null,
    ): CommentView {
        return $this->defaultCall(
            '/comment',
            HttpMethod::Put,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'content' => $content,
                'form_id' => $formId,
                'language_id' => $language?->value,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView,
        );
    }

    public function get(int $commentId): CommentView
    {
        return $this->defaultCall(
            '/comment',
            HttpMethod::Get,
            [
                'id' => $commentId,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView,
        );
    }

    public function getComments(
        Community|int|string|null $community = null,
        ?int $limit = null,
        ?int $maxDepth = null,
        ?int $page = null,
        int|Comment|null $parent = null,
        Post|int|null $post = null,
        ?bool $savedOnly = null,
        ?CommentSortType $sortType = null,
        ?ListingType $listingType = null,
    ): array {
        if ($community instanceof Community) {
            $community = $community->id;
        }
        if ($post instanceof Post) {
            $post = $post->id;
        }
        if ($parent instanceof Comment) {
            $parent = $parent->id;
        }

        return $this->defaultCall(
            '/comment/list',
            HttpMethod::Get,
            [
                'community_id' => is_int($community) ? $community : null,
                'community_name' => is_string($community) ? $community : null,
                'limit' => $limit,
                'max_depth' => $maxDepth,
                'page' => $page,
                'parent_id' => $parent,
                'post_id' => $post,
                'saved_only' => $savedOnly,
                'sort' => $sortType?->value,
                'type_' => $listingType?->value,
            ],
            GetCommentsResponse::class,
            static fn (GetCommentsResponse $response) => $response->comments,
        );
    }
}
