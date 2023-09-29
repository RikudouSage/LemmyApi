<?php

namespace Rikudou\LemmyApi\Endpoint;

use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\CommentSortType;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\View\CommentReportView;
use Rikudou\LemmyApi\Response\View\CommentView;

interface CommentEndpoint
{
    public function create(
        Post|int $post,
        string $content,
        #[Deprecated(since: '0.19.0')]
        ?string $formId = null,
        ?Language $language = null,
        Comment|int|null $parent = null,
    ): CommentView;

    public function get(int $commentId): CommentView;

    /**
     * @return array<CommentView>
     */
    public function getComments(
        Community|int|string|null $community = null,
        ?int $limit = null,
        ?int $maxDepth = null,
        ?int $page = null,
        Comment|int|null $parent = null,
        Post|int|null $post = null,
        ?bool $savedOnly = null,
        ?CommentSortType $sortType = null,
        ?ListingType $listingType = null,
        #[Since('0.19.0')]
        ?bool $likedOnly = null,
        #[Since('0.19.0')]
        ?bool $dislikedOnly = null,
    ): array;

    public function delete(Comment|int $comment): bool;

    public function undelete(Comment|int $comment): bool;

    public function report(Comment|int $comment, string $reason): CommentReportView;

    public function update(
        Comment|int $comment,
        ?string $content = null,
        #[Deprecated(since: '0.19.0')]
        ?string $formId = null,
        ?Language $language = null,
    ): CommentView;
}
