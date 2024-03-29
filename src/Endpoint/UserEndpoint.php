<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Response\Aggregates\PersonAggregates;
use Rikudou\LemmyApi\Response\Model\CaptchaResponse;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\View\CommentView;
use Rikudou\LemmyApi\Response\View\PostView;

interface UserEndpoint
{
    public function get(string|int $usernameOrId): Person;

    public function getCounts(string|int|Person $user): PersonAggregates;

    public function getCommentKarma(int|string|Person $user): int;

    public function getPostKarma(int|string|Person $user): int;

    /**
     * @return array<Community>
     */
    public function getModeratedCommunities(string|int|Person $usernameOrId): array;

    /**
     * @return array<CommentView>
     */
    public function getComments(
        Person|string|int $user,
        ?int $limit = null,
        Community|int|null $community = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?bool $savedOnly = null,
    ): array;

    /**
     * @return array<PostView>
     */
    public function getPosts(
        Person|string|int $user,
        ?int $limit = null,
        Community|int|null $community = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?bool $savedOnly = null,
    ): array;

    public function getCaptcha(): ?CaptchaResponse;
}
