<?php

namespace Rikudou\LemmyApi\Endpoint;

use DateTimeInterface;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Response\AddModToCommunityResponse;
use Rikudou\LemmyApi\Response\BanFromCommunityResponse;
use Rikudou\LemmyApi\Response\CommentReportResponse;
use Rikudou\LemmyApi\Response\CommentResponse;
use Rikudou\LemmyApi\Response\CommunityResponse;
use Rikudou\LemmyApi\Response\GetCommunityResponse;
use Rikudou\LemmyApi\Response\GetReportCountResponse;
use Rikudou\LemmyApi\Response\ListPostReportsResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\CommentReport;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PostReport;
use Rikudou\LemmyApi\Response\PostReportResponse;
use Rikudou\LemmyApi\Response\PostResponse;

final readonly class DefaultModeratorEndpoint extends AbstractEndpoint implements ModeratorEndpoint
{
    public function addModeratorToCommunity(int|Person $user, Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/mod',
            HttpMethod::Post,
            [
                'added' => true,
                'community_id' => is_int($community) ? $community : $community->id,
                'person_id' => is_int($user) ? $user : $user->id,
            ],
            AddModToCommunityResponse::class,
            static fn (AddModToCommunityResponse $response) => true,
        );
    }

    public function removeModeratorFromCommunity(int|Person $user, Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/mod',
            HttpMethod::Post,
            [
                'added' => false,
                'community_id' => is_int($community) ? $community : $community->id,
                'person_id' => is_int($user) ? $user : $user->id,
            ],
            AddModToCommunityResponse::class,
            static fn (AddModToCommunityResponse $response) => true,
        );
    }

    public function banFromCommunity(
        int|Person $user,
        Community|int $community,
        ?string $reason = null,
        ?bool $removeData = null,
        ?DateTimeInterface $expires = null,
    ): bool {
        return $this->defaultCall(
            '/community/ban_user',
            HttpMethod::Post,
            [
                'ban' => true,
                'community_id' => is_int($community) ? $community : $community->id,
                'expires' => $expires,
                'person_id' => is_int($user) ? $user : $user->id,
                'reason' => $reason,
                'remove_data' => $removeData,
            ],
            BanFromCommunityResponse::class,
            static fn (BanFromCommunityResponse $response) => $response->banned,
        );
    }

    public function unbanFromCommunity(int|Person $user, Community|int $community, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/community/ban_user',
            HttpMethod::Post,
            [
                'ban' => false,
                'community_id' => is_int($community) ? $community : $community->id,
                'person_id' => is_int($user) ? $user : $user->id,
                'reason' => $reason,
            ],
            BanFromCommunityResponse::class,
            static fn (BanFromCommunityResponse $response) => !$response->banned,
        );
    }

    public function highlightComment(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/distinguish',
            HttpMethod::Post,
            [
                'distinguished' => true,
                'comment_id' => is_int($comment) ? $comment : $comment->id,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView->comment->distinguished,
        );
    }

    public function unhighlightComment(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/distinguish',
            HttpMethod::Post,
            [
                'distinguished' => false,
                'comment_id' => is_int($comment) ? $comment : $comment->id,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => !$response->commentView->comment->distinguished,
        );
    }

    public function getReportCount(Community|int|null $community = null): GetReportCountResponse
    {
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/user/report_count',
            HttpMethod::Get,
            [
                'community_id' => $community,
            ],
            GetReportCountResponse::class,
        );
    }

    public function listPostReports(
        Community|int|null $community = null,
        ?int $limit = null,
        ?int $page = null,
        ?bool $unresolvedOnly = null,
    ): array {
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/post/report/list',
            HttpMethod::Get,
            [
                'community_id' => $community,
                'limit' => $limit,
                'page' => $page,
                'unresolved_only' => $unresolvedOnly,
            ],
            ListPostReportsResponse::class,
            static fn (ListPostReportsResponse $response) => $response->postReports,
        );
    }

    public function lockPost(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/lock',
            HttpMethod::Post,
            [
                'locked' => true,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->post->locked,
        );
    }

    public function unlockPost(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/lock',
            HttpMethod::Post,
            [
                'locked' => false,
                'post_id' => is_int($post) ? $post : $post->id,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => !$response->postView->post->locked,
        );
    }

    public function removeComment(int|Comment $comment, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/comment/remove',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'reason' => $reason,
                'removed' => true,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView->comment->removed,
        );
    }

    public function restoreRemovedComment(int|Comment $comment, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/comment/remove',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'reason' => $reason,
                'removed' => false,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => !$response->commentView->comment->removed,
        );
    }

    public function removeCommunity(Community|int $community, ?string $reason = null, ?DateTimeInterface $expires = null): bool
    {
        return $this->defaultCall(
            '/community/remove',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'reason' => $reason,
                'removed' => true,
                'expires' => $expires?->getTimestamp(),
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->community->removed,
        );
    }

    public function restoreRemovedCommunity(Community|int $community, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/community/remove',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'reason' => $reason,
                'removed' => false,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => !$response->communityView->community->removed,
        );
    }

    public function removePost(Post|int $post, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/post/remove',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'reason' => $reason,
                'removed' => true,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->post->removed,
        );
    }

    public function restoreRemovedPost(Post|int $post, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/post/remove',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'reason' => $reason,
                'removed' => false,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => !$response->postView->post->removed,
        );
    }

    public function resolveCommentReport(CommentReport|int $commentReport): bool
    {
        return $this->defaultCall(
            '/comment/report/resolve',
            HttpMethod::Put,
            [
                'report_id' => is_int($commentReport) ? $commentReport : $commentReport->id,
                'resolved' => true,
            ],
            CommentReportResponse::class,
            static fn (CommentReportResponse $response) => $response->commentReportView->commentReport->resolved,
        );
    }

    public function unresolveCommentReport(CommentReport|int $commentReport): bool
    {
        return $this->defaultCall(
            '/comment/report/resolve',
            HttpMethod::Put,
            [
                'report_id' => is_int($commentReport) ? $commentReport : $commentReport->id,
                'resolved' => false,
            ],
            CommentReportResponse::class,
            static fn (CommentReportResponse $response) => !$response->commentReportView->commentReport->resolved,
        );
    }

    public function resolvePostReport(PostReport|int $postReport): bool
    {
        return $this->defaultCall(
            '/post/report/resolve',
            HttpMethod::Put,
            [
                'report_id' => is_int($postReport) ? $postReport : $postReport->id,
                'resolved' => true,
            ],
            PostReportResponse::class,
            static fn (PostReportResponse $response) => $response->postReportView->postReport->resolved,
        );
    }

    public function unresolvePostReport(PostReport|int $postReport): bool
    {
        return $this->defaultCall(
            '/post/report/resolve',
            HttpMethod::Put,
            [
                'report_id' => is_int($postReport) ? $postReport : $postReport->id,
                'resolved' => false,
            ],
            PostReportResponse::class,
            static fn (PostReportResponse $response) => !$response->postReportView->postReport->resolved,
        );
    }

    public function transferCommunity(Community|int $community, int|Person $user): bool
    {
        return $this->defaultCall(
            '/community/transfer',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'person_id' => is_int($user) ? $user : $user->id,
            ],
            GetCommunityResponse::class,
            static fn (GetCommunityResponse $response) => true,
        );
    }
}
