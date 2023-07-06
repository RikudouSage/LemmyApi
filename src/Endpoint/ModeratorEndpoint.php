<?php

namespace Rikudou\LemmyApi\Endpoint;

use DateTimeInterface;
use Rikudou\LemmyApi\Response\GetReportCountResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\CommentReport;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PostReport;
use Rikudou\LemmyApi\Response\View\PostReportView;

interface ModeratorEndpoint
{
    public function addModeratorToCommunity(Person|int $user, Community|int $community): bool;

    public function removeModeratorFromCommunity(Person|int $user, Community|int $community): bool;

    public function banFromCommunity(
        Person|int $user,
        Community|int $community,
        ?string $reason = null,
        ?bool $removeData = null,
        ?DateTimeInterface $expires = null,
    ): bool;

    public function unbanFromCommunity(
        Person|int $user,
        Community|int $community,
        ?string $reason = null,
    ): bool;

    public function highlightComment(Comment|int $comment): bool;

    public function unhighlightComment(Comment|int $comment): bool;

    public function getReportCount(Community|int|null $community = null): GetReportCountResponse;

    /**
     * @return array<PostReportView>
     */
    public function listPostReports(
        Community|int|null $community = null,
        ?int $limit = null,
        ?int $page = null,
        ?bool $unresolvedOnly = null,
    ): array;

    public function lockPost(Post|int $post): bool;

    public function unlockPost(Post|int $post): bool;

    public function removeComment(Comment|int $comment, ?string $reason = null): bool;

    public function restoreRemovedComment(Comment|int $comment, ?string $reason = null): bool;

    public function removeCommunity(Community|int $community, ?string $reason = null, ?DateTimeInterface $expires = null): bool;

    public function restoreRemovedCommunity(Community|int $community, ?string $reason = null): bool;

    public function removePost(Post|int $post, ?string $reason = null): bool;

    public function restoreRemovedPost(Post|int $post, ?string $reason = null): bool;

    public function resolveCommentReport(CommentReport|int $commentReport): bool;

    public function unresolveCommentReport(CommentReport|int $commentReport): bool;

    public function resolvePostReport(PostReport|int $postReport): bool;

    public function unresolvePostReport(PostReport|int $postReport): bool;

    public function transferCommunity(Community|int $community, Person|int $user): bool;
}
