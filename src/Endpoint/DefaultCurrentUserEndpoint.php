<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Enum\CommentSortType;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Enum\SubscribedType;
use Rikudou\LemmyApi\Response\BlockCommunityResponse;
use Rikudou\LemmyApi\Response\BlockPersonResponse;
use Rikudou\LemmyApi\Response\CommentReplyResponse;
use Rikudou\LemmyApi\Response\CommentResponse;
use Rikudou\LemmyApi\Response\CommunityResponse;
use Rikudou\LemmyApi\Response\GetPersonMentionsResponse;
use Rikudou\LemmyApi\Response\GetRepliesResponse;
use Rikudou\LemmyApi\Response\GetUnreadCountResponse;
use Rikudou\LemmyApi\Response\LoginResponse;
use Rikudou\LemmyApi\Response\Model\Comment;
use Rikudou\LemmyApi\Response\Model\CommentReply;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\PersonMention;
use Rikudou\LemmyApi\Response\Model\Post;
use Rikudou\LemmyApi\Response\Model\PrivateMessage;
use Rikudou\LemmyApi\Response\PersonMentionResponse;
use Rikudou\LemmyApi\Response\PostResponse;
use Rikudou\LemmyApi\Response\PrivateMessageReportResponse;
use Rikudou\LemmyApi\Response\PrivateMessageResponse;
use Rikudou\LemmyApi\Response\PrivateMessagesResponse;
use Rikudou\LemmyApi\Response\View\PrivateMessageReportView;
use Rikudou\LemmyApi\Response\View\PrivateMessageView;
use SensitiveParameter;

final readonly class DefaultCurrentUserEndpoint extends AbstractEndpoint implements CurrentUserEndpoint
{
    public function getMentions(
        ?int $limit = null,
        ?int $page = null,
        ?CommentSortType $sort = null,
        ?bool $unreadOnly = null,
    ): array {
        return $this->defaultCall(
            '/user/mention',
            HttpMethod::Get,
            [
                'limit' => $limit,
                'page' => $page,
                'sort' => $sort?->value,
                'unread_only' => $unreadOnly,
            ],
            GetPersonMentionsResponse::class,
            static fn (GetPersonMentionsResponse $response) => $response->mentions,
        );
    }

    public function unsubscribeFromCommunity(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/follow',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'follow' => false,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->subscribed === SubscribedType::NotSubscribed,
        );
    }

    public function blockCommunity(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/block',
            HttpMethod::Post,
            [
                'block' => true,
                'community_id' => is_int($community) ? $community : $community->id,
            ],
            BlockCommunityResponse::class,
            static fn (BlockCommunityResponse $response) => $response->blocked,
        );
    }

    public function unblockCommunity(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/block',
            HttpMethod::Post,
            [
                'block' => false,
                'community_id' => is_int($community) ? $community : $community->id,
            ],
            BlockCommunityResponse::class,
            static fn (BlockCommunityResponse $response) => !$response->blocked,
        );
    }

    public function blockUser(int|Person $user): bool
    {
        return $this->defaultCall(
            '/user/block',
            HttpMethod::Post,
            [
                'block' => true,
                'person_id' => is_int($user) ? $user : $user->id,
            ],
            BlockPersonResponse::class,
            static fn (BlockPersonResponse $response) => $response->blocked,
        );
    }

    public function unblockUser(int|Person $user): bool
    {
        return $this->defaultCall(
            '/user/block',
            HttpMethod::Post,
            [
                'block' => false,
                'person_id' => is_int($user) ? $user : $user->id,
            ],
            BlockPersonResponse::class,
            static fn (BlockPersonResponse $response) => !$response->blocked,
        );
    }

    public function changePassword(#[SensitiveParameter] string $oldPassword, #[SensitiveParameter] string $newPassword): LoginResponse
    {
        return $this->defaultCall(
            '/user/change_password',
            HttpMethod::Put,
            [
                'new_password' => $newPassword,
                'new_password_verify' => $newPassword,
                'old_password' => $oldPassword,
            ],
            LoginResponse::class,
        );
    }

    public function changePasswordAfterReset(#[SensitiveParameter] string $newPassword, #[SensitiveParameter] string $token): LoginResponse
    {
        return $this->defaultCall(
            '/user/password_change',
            HttpMethod::Post,
            [
                'password' => $newPassword,
                'password_verify' => $newPassword,
                'token' => $token,
            ],
            LoginResponse::class,
        );
    }

    public function resetPassword(string $email): bool
    {
        $this->defaultCall(
            '/user/password_reset',
            HttpMethod::Post,
            [
                'email' => $email,
            ],
            null,
        );

        return true;
    }

    public function sendPrivateMessage(int|Person $recipient, string $content): PrivateMessageView
    {
        return $this->defaultCall(
            '/private_message',
            HttpMethod::Post,
            [
                'content' => $content,
                'recipient_id' => is_int($recipient) ? $recipient : $recipient->id,
            ],
            PrivateMessageResponse::class,
            static fn (PrivateMessageResponse $response) => $response->privateMessageView,
        );
    }

    public function updatePrivateMessage(int|PrivateMessage $message, string $content): PrivateMessageView
    {
        return $this->defaultCall(
            '/private_message',
            HttpMethod::Put,
            [
                'content' => $content,
                'private_message_id' => is_int($message) ? $message : $message->id,
            ],
            PrivateMessageResponse::class,
            static fn (PrivateMessageResponse $response) => $response->privateMessageView,
        );
    }

    public function reportPrivateMessage(int|PrivateMessage $message, string $reason): PrivateMessageReportView
    {
        return $this->defaultCall(
            '/private_message/report',
            HttpMethod::Post,
            [
                'private_message_id' => is_int($message) ? $message : $message->id,
                'reason' => $reason,
            ],
            PrivateMessageReportResponse::class,
            static fn (PrivateMessageReportResponse $response) => $response->privateMessageReportView,
        );
    }

    public function deleteCurrentAccount(#[SensitiveParameter] string $password): bool
    {
        $this->defaultCall(
            '/user/delete_account',
            HttpMethod::Post,
            [
                'password' => $password,
            ],
            null,
        );

        return true;
    }

    public function deletePrivateMessage(int|PrivateMessage $message): bool
    {
        return $this->defaultCall(
            '/private_message/delete',
            HttpMethod::Post,
            [
                'deleted' => true,
                'private_message_id' => is_int($message) ? $message : $message->id,
            ],
            PrivateMessageResponse::class,
            static fn (PrivateMessageResponse $response) => $response->privateMessageView->privateMessage->deleted,
        );
    }

    public function undeletePrivateMessage(int|PrivateMessage $message): bool
    {
        return $this->defaultCall(
            '/private_message/delete',
            HttpMethod::Post,
            [
                'deleted' => false,
                'private_message_id' => is_int($message) ? $message : $message->id,
            ],
            PrivateMessageResponse::class,
            static fn (PrivateMessageResponse $response) => !$response->privateMessageView->privateMessage->deleted,
        );
    }

    public function subscribeToCommunity(Community|int $community): bool
    {
        return $this->defaultCall(
            '/community/follow',
            HttpMethod::Post,
            [
                'community_id' => is_int($community) ? $community : $community->id,
                'follow' => true,
            ],
            CommunityResponse::class,
            static fn (CommunityResponse $response) => $response->communityView->subscribed !== SubscribedType::NotSubscribed,
        );
    }

    public function getPrivateMessages(?int $limit = null, ?int $page = null, ?bool $unreadOnly = null): array
    {
        return $this->defaultCall(
            '/private_message/list',
            HttpMethod::Get,
            [
                'limit' => $limit,
                'page' => $page,
                'unread_only' => $unreadOnly,
            ],
            PrivateMessagesResponse::class,
            static fn (PrivateMessagesResponse $response) => $response->privateMessages,
        );
    }

    public function getReplies(
        ?int $limit = null,
        ?int $page = null,
        ?CommentSortType $sort = null,
        ?bool $unreadOnly = null,
    ): array {
        return $this->defaultCall(
            '/user/replies',
            HttpMethod::Get,
            [
                'limit' => $limit,
                'page' => $page,
                'sort' => $sort?->value,
                'unread_only' => $unreadOnly,
            ],
            GetRepliesResponse::class,
            static fn (GetRepliesResponse $response) => $response->replies,
        );
    }

    public function getUnreadCount(): GetUnreadCountResponse
    {
        return $this->defaultCall(
            '/user/unread_count',
            HttpMethod::Get,
            [],
            GetUnreadCountResponse::class,
        );
    }

    public function upvoteComment(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/like',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'score' => 1,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView->myVote === 1,
        );
    }

    public function downvoteComment(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/like',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'score' => -1,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView->myVote === -1,
        );
    }

    public function resetCommentUpvoteDownvote(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/like',
            HttpMethod::Post,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'score' => 0,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => ($response->commentView->myVote ?? 0) === 0,
        );
    }

    public function upvotePost(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/like',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'score' => 1,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->myVote === 1,
        );
    }

    public function downvotePost(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/like',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'score' => -1,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->myVote === -1,
        );
    }

    public function resetPostUpvoteDownvote(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/like',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'score' => 0,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => ($response->postView->myVote ?? 0) === 0,
        );
    }

    public function markAllAsRead(): bool
    {
        return $this->defaultCall(
            '/user/mark_all_as_read',
            HttpMethod::Post,
            [],
            GetRepliesResponse::class,
            static fn (GetRepliesResponse $response) => true,
        );
    }

    public function markCommentReplyAsRead(int|CommentReply $reply): bool
    {
        return $this->defaultCall(
            '/comment/mark_as_read',
            HttpMethod::Post,
            [
                'comment_reply_id' => is_int($reply) ? $reply : $reply->id,
                'read' => true,
            ],
            CommentReplyResponse::class,
            static fn (CommentReplyResponse $response) => $response->commentReplyView->commentReply->read,
        );
    }

    public function markCommentReplyAsUnread(int|CommentReply $reply): bool
    {
        return $this->defaultCall(
            '/comment/mark_as_read',
            HttpMethod::Post,
            [
                'comment_reply_id' => is_int($reply) ? $reply : $reply->id,
                'read' => false,
            ],
            CommentReplyResponse::class,
            static fn (CommentReplyResponse $response) => !$response->commentReplyView->commentReply->read,
        );
    }

    public function markMentionAsRead(int|PersonMention $mention): bool
    {
        return $this->defaultCall(
            '/user/mention/mark_as_read',
            HttpMethod::Post,
            [
                'person_mention_id' => is_int($mention) ? $mention : $mention->id,
                'read' => true,
            ],
            PersonMentionResponse::class,
            static fn (PersonMentionResponse $response) => $response->personMentionView->personMention->read,
        );
    }

    public function markMentionAsUnread(int|PersonMention $mention): bool
    {
        return $this->defaultCall(
            '/user/mention/mark_as_read',
            HttpMethod::Post,
            [
                'person_mention_id' => is_int($mention) ? $mention : $mention->id,
                'read' => false,
            ],
            PersonMentionResponse::class,
            static fn (PersonMentionResponse $response) => !$response->personMentionView->personMention->read,
        );
    }

    public function markPostAsRead(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/mark_as_read',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'read' => true,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->read,
        );
    }

    public function markPostAsUnread(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/mark_as_read',
            HttpMethod::Post,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'read' => false,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => !$response->postView->read,
        );
    }

    public function markPrivateMessageAsRead(int|PrivateMessage $privateMessage): bool
    {
        return $this->defaultCall(
            '/private_message/mark_as_read',
            HttpMethod::Post,
            [
                'private_message_id' => is_int($privateMessage) ? $privateMessage : $privateMessage->id,
                'read' => true,
            ],
            PrivateMessageResponse::class,
            static fn (PrivateMessageResponse $response) => $response->privateMessageView->privateMessage->read,
        );
    }

    public function markPrivateMessageAsUnread(int|PrivateMessage $privateMessage): bool
    {
        return $this->defaultCall(
            '/private_message/mark_as_read',
            HttpMethod::Post,
            [
                'private_message_id' => is_int($privateMessage) ? $privateMessage : $privateMessage->id,
                'read' => false,
            ],
            PrivateMessageResponse::class,
            static fn (PrivateMessageResponse $response) => !$response->privateMessageView->privateMessage->read,
        );
    }

    public function saveComment(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/save',
            HttpMethod::Put,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'save' => true,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => $response->commentView->saved,
        );
    }

    public function unsaveComment(int|Comment $comment): bool
    {
        return $this->defaultCall(
            '/comment/save',
            HttpMethod::Put,
            [
                'comment_id' => is_int($comment) ? $comment : $comment->id,
                'save' => false,
            ],
            CommentResponse::class,
            static fn (CommentResponse $response) => !$response->commentView->saved,
        );
    }

    public function savePost(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/save',
            HttpMethod::Put,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'save' => true,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => $response->postView->saved,
        );
    }

    public function unsavePost(Post|int $post): bool
    {
        return $this->defaultCall(
            '/post/save',
            HttpMethod::Put,
            [
                'post_id' => is_int($post) ? $post : $post->id,
                'save' => false,
            ],
            PostResponse::class,
            static fn (PostResponse $response) => !$response->postView->saved,
        );
    }

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
        ?bool $infiniteScrollEnabled = null,
    ): bool {
        $args = get_defined_vars();
        $bodyKeys = array_map(
            static fn (string $key) => (string) preg_replace_callback(
                '[A-Z]',
                static fn (array $matches) => '_' . strtolower($matches[1]),
                $key,
            ),
            array_keys($args),
        );
        $body = array_combine($bodyKeys, $args);

        return $this->defaultCall(
            '/user/save_user_settings',
            HttpMethod::Put,
            $body,
            LoginResponse::class,
            static fn (LoginResponse $response) => true,
        );
    }
}
