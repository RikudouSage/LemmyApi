<?php

namespace Rikudou\LemmyApi\Endpoint;

use DateTimeInterface;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\GetUnreadRegistrationApplicationCountResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\CustomEmoji;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PrivateMessageReport;
use Rikudou\LemmyApi\Response\Model\RegistrationApplication;
use Rikudou\LemmyApi\Response\View\PersonView;
use Rikudou\LemmyApi\Response\View\PrivateMessageReportView;
use Rikudou\LemmyApi\Response\View\RegistrationApplicationView;

interface AdminEndpoint
{
    public function banUser(
        Person|int $user,
        ?DateTimeInterface $expires = null,
        ?string $reason = null,
        ?bool $removeData = null,
    ): bool;

    public function unbanUser(
        Person|int $user,
        ?DateTimeInterface $expires = null,
        ?string $reason = null,
        ?bool $removeData = null,
    ): bool;

    /**
     * @return array<PersonView>
     */
    public function getBannedUsers(): array;

    public function addAdmin(Person|int $user): bool;

    public function leaveAdmin(): bool;

    /**
     * @return array<RegistrationApplicationView>
     */
    public function listRegistrationApplications(?int $limit = null, ?int $page = null, ?bool $unreadOnly = null): array;

    public function approveRegistrationApplication(RegistrationApplication|int $application): bool;

    public function rejectRegistrationApplication(RegistrationApplication|int $application, ?string $denyReason = null): bool;

    /**
     * @param array<string> $keywords
     */
    public function createCustomEmoji(
        string $imageUrl,
        string $shortcode,
        string $altText,
        string $category,
        array $keywords,
    ): CustomEmoji;

    public function deleteCustomEmoji(CustomEmoji|int $customEmoji): bool;

    /**
     * @param array<string> $keywords
     */
    public function editCustomEmoji(
        CustomEmoji|int $customEmoji,
        string $imageUrl,
        string $altText,
        string $category,
        array $keywords,
    ): bool;

    public function getUnreadRegistrationApplicationCount(): GetUnreadRegistrationApplicationCountResponse;

    public function purgeComment(Comment|int $comment, ?string $reason = null): bool;

    public function purgeCommunity(Community|int $community, ?string $reason = null): bool;

    public function purgeUser(Person|int $user, ?string $reason = null): bool;

    public function purgePost(Post|int $post, ?string $reason = null): bool;

    public function resolvePrivateMessageReport(PrivateMessageReport|int $report): bool;

    public function unresolvePrivateMessageReport(PrivateMessageReport|int $report): bool;

    /**
     * @return array<PrivateMessageReportView>
     */
    public function listPrivateMessageReports(
        ?int $limit = null,
        ?int $page = null,
        ?bool $unresolvedOnly = null,
    ): array;

    #[Since('0.19.0')]
    public function hideCommunity(Community|int $community, ?string $reason = null): bool;

    #[Since('0.19.0')]
    public function unhideCommunity(Community|int $community): bool;
}
