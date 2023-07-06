<?php

namespace Rikudou\LemmyApi\Endpoint;

use DateTimeInterface;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Response\AddAdminResponse;
use Rikudou\LemmyApi\Response\BannedPersonsResponse;
use Rikudou\LemmyApi\Response\BanPersonResponse;
use Rikudou\LemmyApi\Response\CustomEmojiResponse;
use Rikudou\LemmyApi\Response\DeleteCustomEmojiResponse;
use Rikudou\LemmyApi\Response\GetSiteResponse;
use Rikudou\LemmyApi\Response\GetUnreadRegistrationApplicationCountResponse;
use Rikudou\LemmyApi\Response\ListPrivateMessageReportsResponse;
use Rikudou\LemmyApi\Response\ListRegistrationApplicationsResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\CustomEmoji;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PrivateMessageReport;
use Rikudou\LemmyApi\Response\Model\RegistrationApplication;
use Rikudou\LemmyApi\Response\PrivateMessageReportResponse;
use Rikudou\LemmyApi\Response\PurgeItemResponse;
use Rikudou\LemmyApi\Response\RegistrationApplicationResponse;
use Rikudou\LemmyApi\Response\View\PersonView;

final readonly class DefaultAdminEndpoint extends AbstractEndpoint implements AdminEndpoint
{
    public function banUser(
        int|Person $user,
        ?DateTimeInterface $expires = null,
        ?string $reason = null,
        ?bool $removeData = null,
    ): bool {
        return $this->defaultCall(
            '/user/ban',
            HttpMethod::Post,
            [
                'ban' => true,
                'person_id' => $user,
                'expires' => $expires?->getTimestamp(),
                'reason' => $reason,
                'remove_data' => $removeData,
            ],
            BanPersonResponse::class,
            static fn (BanPersonResponse $response) => $response->banned,
        );
    }

    public function unbanUser(
        int|Person $user,
        ?DateTimeInterface $expires = null,
        ?string $reason = null,
        ?bool $removeData = null,
    ): bool {
        return $this->defaultCall(
            '/user/ban',
            HttpMethod::Post,
            [
                'ban' => false,
                'person_id' => $user,
                'expires' => $expires?->getTimestamp(),
                'reason' => $reason,
                'remove_data' => $removeData,
            ],
            BanPersonResponse::class,
            static fn (BanPersonResponse $response) => !$response->banned,
        );
    }

    public function getBannedUsers(): array
    {
        return $this->defaultCall(
            '/user/banned',
            HttpMethod::Get,
            [],
            BannedPersonsResponse::class,
            static fn (BannedPersonsResponse $response) => $response->banned,
        );
    }

    public function addAdmin(int|Person $user): bool
    {
        return $this->defaultCall(
            '/admin/add',
            HttpMethod::Post,
            [
                'person_id' => is_int($user) ? $user : $user->id,
                'added' => true,
            ],
            AddAdminResponse::class,
            static fn (AddAdminResponse $response) => count(
                array_filter(
                    $response->admins,
                    static fn (PersonView $personView) => $personView->person->id === $user,
                )
            ) === 1
        );
    }

    public function leaveAdmin(): bool
    {
        return $this->defaultCall(
            '/user/leave_admin',
            HttpMethod::Post,
            [],
            GetSiteResponse::class,
            static fn (GetSiteResponse $response) => true,
        );
    }

    public function listRegistrationApplications(?int $limit = null, ?int $page = null, ?bool $unreadOnly = null): array
    {
        return $this->defaultCall(
            '/admin/registration_application/list',
            HttpMethod::Get,
            [],
            ListRegistrationApplicationsResponse::class,
            static fn (ListRegistrationApplicationsResponse $response) => $response->registrationApplications,
        );
    }

    public function approveRegistrationApplication(int|RegistrationApplication $application): bool
    {
        return $this->defaultCall(
            '/admin/registration_application/approve',
            HttpMethod::Put,
            [
                'approve' => true,
                'id' => is_int($application) ? $application : $application->id,
            ],
            RegistrationApplicationResponse::class,
            static fn (RegistrationApplicationResponse $response) => true,
        );
    }

    public function rejectRegistrationApplication(int|RegistrationApplication $application, ?string $denyReason = null): bool
    {
        return $this->defaultCall(
            '/admin/registration_application/approve',
            HttpMethod::Put,
            [
                'approve' => true,
                'id' => is_int($application) ? $application : $application->id,
                'deny_reason' => $denyReason,
            ],
            RegistrationApplicationResponse::class,
            static fn (RegistrationApplicationResponse $response) => true,
        );
    }

    public function createCustomEmoji(
        string $imageUrl,
        string $shortcode,
        string $altText,
        string $category,
        array $keywords,
    ): CustomEmoji {
        return $this->defaultCall(
            '/custom_emoji',
            HttpMethod::Post,
            [
                'alt_text' => $altText,
                'category' => $category,
                'image_url' => $imageUrl,
                'keywords' => $keywords,
                'shortcode' => $shortcode,
            ],
            CustomEmojiResponse::class,
            static fn (CustomEmojiResponse $response) => $response->customEmoji->customEmoji,
        );
    }

    public function deleteCustomEmoji(CustomEmoji|int $customEmoji): bool
    {
        return $this->defaultCall(
            '/custom_emoji/delete',
            HttpMethod::Post,
            [
                'id' => is_int($customEmoji) ? $customEmoji : $customEmoji->id,
            ],
            DeleteCustomEmojiResponse::class,
            static fn (DeleteCustomEmojiResponse $response) => $response->success,
        );
    }

    public function editCustomEmoji(
        CustomEmoji|int $customEmoji,
        string $imageUrl,
        string $altText,
        string $category,
        array $keywords,
    ): bool {
        return $this->defaultCall(
            '/custom_emoji',
            HttpMethod::Put,
            [
                'alt_text' => $altText,
                'category' => $category,
                'id' => is_int($customEmoji) ? $customEmoji : $customEmoji->id,
                'image_url' => $imageUrl,
                'keywords' => $keywords,
            ],
            CustomEmojiResponse::class,
            static fn (CustomEmojiResponse $response) => true,
        );
    }

    public function getUnreadRegistrationApplicationCount(): GetUnreadRegistrationApplicationCountResponse
    {
        return $this->defaultCall(
            '/admin/registration_application/count',
            HttpMethod::Get,
            [],
            GetUnreadRegistrationApplicationCountResponse::class,
        );
    }

    public function purgeComment(int|Comment $comment, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/admin/purge/comment',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'reason' => $reason,
            ],
            PurgeItemResponse::class,
            static fn (PurgeItemResponse $response) => $response->success,
        );
    }

    public function purgeCommunity(Community|int $community, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/admin/purge/community',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'reason' => $reason,
            ],
            PurgeItemResponse::class,
            static fn (PurgeItemResponse $response) => $response->success,
        );
    }

    public function purgeUser(int|Person $user, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/admin/purge/person',
            HttpMethod::Post,
            [
                'person_id' => is_int($user) ? $user : $user->id,
                'reason' => $reason,
            ],
            PurgeItemResponse::class,
            static fn (PurgeItemResponse $response) => $response->success,
        );
    }

    public function purgePost(Post|int $post, ?string $reason = null): bool
    {
        return $this->defaultCall(
            '/admin/purge/post',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'reason' => $reason,
            ],
            PurgeItemResponse::class,
            static fn (PurgeItemResponse $response) => $response->success,
        );
    }

    public function resolvePrivateMessageReport(int|PrivateMessageReport $report): bool
    {
        return $this->defaultCall(
            '/private_message/report/resolve',
            HttpMethod::Put,
            [
                'report_id' => is_int($report) ? $report : $report->id,
                'resolved' => true,
            ],
            PrivateMessageReportResponse::class,
            static fn (PrivateMessageReportResponse $response) => $response->privateMessageReportView->privateMessageReport->resolved,
        );
    }

    public function unresolvePrivateMessageReport(int|PrivateMessageReport $report): bool
    {
        return $this->defaultCall(
            '/private_message/report/resolve',
            HttpMethod::Put,
            [
                'report_id' => is_int($report) ? $report : $report->id,
                'resolved' => false,
            ],
            PrivateMessageReportResponse::class,
            static fn (PrivateMessageReportResponse $response) => !$response->privateMessageReportView->privateMessageReport->resolved,
        );
    }

    public function listPrivateMessageReports(?int $limit = null, ?int $page = null, ?bool $unresolvedOnly = null): array
    {
        return $this->defaultCall(
            '/private_message/report/list',
            HttpMethod::Get,
            [
                'limit' => $limit,
                'page' => $page,
                'unresolved_only' => $unresolvedOnly,
            ],
            ListPrivateMessageReportsResponse::class,
            static fn (ListPrivateMessageReportsResponse $response) => $response->privateMessageReports,
        );
    }
}
