<?php

namespace Rikudou\LemmyApi\Endpoint;

use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\CommentSortType;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\GetUnreadCountResponse;
use Rikudou\LemmyApi\Response\LoginResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\CommentReply;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Instance;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\PersonMention;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PrivateMessage;
use Rikudou\LemmyApi\Response\View\CommentReplyView;
use Rikudou\LemmyApi\Response\View\PersonMentionView;
use Rikudou\LemmyApi\Response\View\PrivateMessageReportView;
use Rikudou\LemmyApi\Response\View\PrivateMessageView;
use SensitiveParameter;

interface CurrentUserEndpoint
{
    public function blockCommunity(Community|int $community): bool;

    public function unblockCommunity(Community|int $community): bool;

    public function subscribeToCommunity(Community|int $community): bool;

    public function unsubscribeFromCommunity(Community|int $community): bool;

    public function blockUser(Person|int $user): bool;

    public function unblockUser(Person|int $user): bool;

    public function changePassword(#[SensitiveParameter] string $oldPassword, #[SensitiveParameter] string $newPassword): LoginResponse;

    public function changePasswordAfterReset(#[SensitiveParameter] string $newPassword, #[SensitiveParameter] string $token): LoginResponse;

    public function resetPassword(string $email): bool;

    public function sendPrivateMessage(Person|int $recipient, string $content): PrivateMessageView;

    public function updatePrivateMessage(PrivateMessage|int $message, string $content): PrivateMessageView;

    public function reportPrivateMessage(PrivateMessage|int $message, string $reason): PrivateMessageReportView;

    /**
     * @return array<PrivateMessageView>
     */
    public function getPrivateMessages(
        ?int $limit = null,
        ?int $page = null,
        ?bool $unreadOnly = null,
        #[Since('0.19.0')]
        Person|int|null $creator = null,
    ): array;

    public function deletePrivateMessage(PrivateMessage|int $message): bool;

    public function undeletePrivateMessage(PrivateMessage|int $message): bool;

    public function deleteCurrentAccount(#[SensitiveParameter] string $password): bool;

    /**
     * @return array<PersonMentionView>
     */
    public function getMentions(
        ?int $limit = null,
        ?int $page = null,
        ?CommentSortType $sort = null,
        ?bool $unreadOnly = null,
    ): array;

    /**
     * @return array<CommentReplyView>
     */
    public function getReplies(
        ?int $limit = null,
        ?int $page = null,
        ?CommentSortType $sort = null,
        ?bool $unreadOnly = null,
    ): array;

    public function getUnreadCount(): GetUnreadCountResponse;

    public function upvoteComment(Comment|int $comment): bool;

    public function downvoteComment(Comment|int $comment): bool;

    public function resetCommentUpvoteDownvote(Comment|int $comment): bool;

    public function upvotePost(Post|int $post): bool;

    public function downvotePost(Post|int $post): bool;

    public function resetPostUpvoteDownvote(Post|int $post): bool;

    public function markAllAsRead(): bool;

    public function markCommentReplyAsRead(CommentReply|int $reply): bool;

    public function markCommentReplyAsUnread(CommentReply|int $reply): bool;

    public function markMentionAsRead(PersonMention|int $mention): bool;

    public function markMentionAsUnread(PersonMention|int $mention): bool;

    public function markPostAsRead(Post|int $post): bool;

    public function markPostAsUnread(Post|int $post): bool;

    public function markPrivateMessageAsRead(PrivateMessage|int $privateMessage): bool;

    public function markPrivateMessageAsUnread(PrivateMessage|int $privateMessage): bool;

    public function saveComment(Comment|int $comment): bool;

    public function unsaveComment(Comment|int $comment): bool;

    public function savePost(Post|int $post): bool;

    public function unsavePost(Post|int $post): bool;

    /**
     * @param array<Language>|null $discussionLanguages
     */
    public function saveSettings(
        ?string $avatar = null,
        ?string $banner = null,
        ?string $bio = null,
        ?bool $botAccount = null,
        ?ListingType $defaultListingType = null,
        ?SortType $defaultSortType = null,
        ?array $discussionLanguages = null,
        ?string $displayName = null,
        ?string $email = null,
        #[Deprecated(since: '0.19.0')]
        ?string $generateTotp2Fa = null,
        ?string $interfaceLanguage = null,
        ?string $matrixUserId = null,
        ?bool $sendNotificationsToEmail = null,
        ?bool $showAvatars = null,
        ?bool $showBotAccounts = null,
        ?bool $showNewPostNotifs = null,
        ?bool $showNsfw = null,
        ?bool $showReadPosts = null,
        ?bool $showScores = null,
        ?string $theme = null,
        ?bool $openLinksInNewTab = null,
        #[Since('0.19.0')]
        ?bool $infiniteScrollEnabled = null,
        #[Since('0.19.0')]
        ?bool $blurNsfw = null,
        #[Since('0.19.0')]
        ?bool $autoExpand = null,
    ): bool;

    #[Since('0.19.0')]
    public function blockInstance(Instance|int $instance): bool;

    #[Since('0.19.0')]
    public function unblockInstance(Instance|int $instance): bool;

    public function deleteAccount(#[SensitiveParameter] string $password, #[Since('0.19.0')] ?bool $deleteContent = null): void;

    #[Since('0.19.0')]
    public function generateTotpSecret(): string;

    #[Since('0.19.0')]
    public function updateTotp(string $token, bool $enabled): bool;
}
