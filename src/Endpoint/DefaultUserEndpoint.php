<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Attribute\NoAuth;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Helper\HttpModuleTrait;
use Rikudou\LemmyApi\Response\Aggregates\PersonAggregates;
use Rikudou\LemmyApi\Response\GetCaptchaResponse;
use Rikudou\LemmyApi\Response\GetPersonDetailsResponse;
use Rikudou\LemmyApi\Response\Model\CaptchaResponse;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\View\CommunityModeratorView;

#[NoAuth]
final readonly class DefaultUserEndpoint extends AbstractEndpoint implements UserEndpoint
{
    use HttpModuleTrait;

    public function get(
        string|int $usernameOrId
    ): Person {
        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'person_id' => is_int($usernameOrId) ? $usernameOrId : null,
                'username' => is_string($usernameOrId) ? $usernameOrId : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->personView->person,
        );
    }

    public function getCounts(int|string|Person $user): PersonAggregates
    {
        if ($user instanceof Person) {
            $user = $user->id;
        }

        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'person_id' => is_int($user) ? $user : null,
                'username' => is_string($user) ? $user : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->personView->counts,
        );
    }

    public function getModeratedCommunities(int|string|Person $usernameOrId): array
    {
        if ($usernameOrId instanceof Person) {
            $usernameOrId = $usernameOrId->id;
        }

        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'person_id' => is_int($usernameOrId) ? $usernameOrId : null,
                'username' => is_string($usernameOrId) ? $usernameOrId : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => array_map(
                static fn (CommunityModeratorView $view) => $view->community,
                $response->moderates,
            ),
        );
    }

    public function getComments(
        int|string|Person $user,
        ?int $limit = null,
        Community|int|null $community = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?bool $savedOnly = null,
    ): array {
        if ($user instanceof Person) {
            $user = $user->id;
        }
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'community_id' => $community,
                'limit' => $limit,
                'page' => $page,
                'person_id' => is_int($user) ? $user : null,
                'saved_only' => $savedOnly,
                'sort' => $sort?->value,
                'username' => is_string($user) ? $user : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->comments,
        );
    }

    public function getCommentKarma(
        int|string|Person $user,
    ): int {
        if ($user instanceof Person) {
            $user = $user->id;
        }

        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'person_id' => is_int($user) ? $user : null,
                'username' => is_string($user) ? $user : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->personView->counts->commentScore,
        );
    }

    public function getPostKarma(int|string|Person $user): int
    {
        if ($user instanceof Person) {
            $user = $user->id;
        }

        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'person_id' => is_int($user) ? $user : null,
                'username' => is_string($user) ? $user : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->personView->counts->postScore,
        );
    }

    public function getPosts(
        int|string|Person $user,
        ?int $limit = null,
        Community|int|null $community = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?bool $savedOnly = null,
    ): array {
        if ($user instanceof Person) {
            $user = $user->id;
        }
        if ($community instanceof Community) {
            $community = $community->id;
        }

        return $this->defaultCall(
            '/user',
            HttpMethod::Get,
            [
                'community_id' => $community,
                'limit' => $limit,
                'page' => $page,
                'person_id' => is_int($user) ? $user : null,
                'saved_only' => $savedOnly,
                'sort' => $sort?->value,
                'username' => is_string($user) ? $user : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->posts,
        );
    }

    public function getCaptcha(): ?CaptchaResponse
    {
        return $this->defaultCall(
            '/user/get_captcha',
            HttpMethod::Get,
            [],
            GetCaptchaResponse::class,
            static fn (GetCaptchaResponse $response) => $response->ok,
        );
    }
}
