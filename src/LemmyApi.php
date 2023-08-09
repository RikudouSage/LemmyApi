<?php

namespace Rikudou\LemmyApi;

use Rikudou\LemmyApi\Endpoint\AdminEndpoint;
use Rikudou\LemmyApi\Endpoint\CommentEndpoint;
use Rikudou\LemmyApi\Endpoint\CommunityEndpoint;
use Rikudou\LemmyApi\Endpoint\CurrentUserEndpoint;
use Rikudou\LemmyApi\Endpoint\MiscellaneousEndpoint;
use Rikudou\LemmyApi\Endpoint\ModeratorEndpoint;
use Rikudou\LemmyApi\Endpoint\PostEndpoint;
use Rikudou\LemmyApi\Endpoint\SiteEndpoint;
use Rikudou\LemmyApi\Endpoint\UserEndpoint;
use Rikudou\LemmyApi\Response\LoginResponse;
use SensitiveParameter;

interface LemmyApi
{
    public function login(
        string $username,
        #[SensitiveParameter] string $password,
        #[SensitiveParameter] ?string $totpToken = null,
    ): LoginResponse;

    public function register(
        string $username,
        #[SensitiveParameter] string $password,
        bool $showNsfw,
        ?string $email = null,
        ?string $answer = null,
        ?string $captchaAnswer = null,
        ?string $captchaUuid = null,
        ?string $honeypot = null,
    ): LoginResponse;

    public function getJwt(): ?string;

    public function setJwt(?string $jwt): void;

    public function user(): UserEndpoint;

    public function currentUser(): CurrentUserEndpoint;

    public function admin(): AdminEndpoint;

    public function moderator(): ModeratorEndpoint;

    public function post(): PostEndpoint;

    public function comment(): CommentEndpoint;

    public function community(): CommunityEndpoint;

    public function site(): SiteEndpoint;

    public function miscellaneous(): MiscellaneousEndpoint;
}
