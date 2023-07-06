<?php

namespace Rikudou\LemmyApi\Endpoint;

use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Helper\HttpModuleTrait;
use Rikudou\LemmyApi\Response\GetCaptchaResponse;
use Rikudou\LemmyApi\Response\GetPersonDetailsResponse;
use Rikudou\LemmyApi\Response\Model\CaptchaResponse;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;

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
                'personId' => is_int($usernameOrId) ? $usernameOrId : null,
                'username' => is_string($usernameOrId) ? $usernameOrId : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->personView->person,
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
                'communityId' => $community,
                'limit' => $limit,
                'page' => $page,
                'personId' => is_int($user) ? $user : null,
                'savedOnly' => $savedOnly,
                'sort' => $sort,
                'username' => is_string($user) ? $user : null,
            ],
            GetPersonDetailsResponse::class,
            static fn (GetPersonDetailsResponse $response) => $response->comments,
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
                'communityId' => $community,
                'limit' => $limit,
                'page' => $page,
                'personId' => is_int($user) ? $user : null,
                'savedOnly' => $savedOnly,
                'sort' => $sort,
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
