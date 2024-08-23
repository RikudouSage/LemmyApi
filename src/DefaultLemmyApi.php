<?php

namespace Rikudou\LemmyApi;

use JetBrains\PhpStorm\ExpectedValues;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Rikudou\LemmyApi\Endpoint\AdminEndpoint;
use Rikudou\LemmyApi\Endpoint\CommentEndpoint;
use Rikudou\LemmyApi\Endpoint\CommunityEndpoint;
use Rikudou\LemmyApi\Endpoint\CurrentUserEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultAdminEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultCommentEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultCommunityEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultCurrentUserEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultMiscellaneousEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultModeratorEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultPostEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultSiteEndpoint;
use Rikudou\LemmyApi\Endpoint\DefaultUserEndpoint;
use Rikudou\LemmyApi\Endpoint\MiscellaneousEndpoint;
use Rikudou\LemmyApi\Endpoint\ModeratorEndpoint;
use Rikudou\LemmyApi\Endpoint\PostEndpoint;
use Rikudou\LemmyApi\Endpoint\SiteEndpoint;
use Rikudou\LemmyApi\Endpoint\UserEndpoint;
use Rikudou\LemmyApi\Enum\AuthMode;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\LemmyApiVersion;
use Rikudou\LemmyApi\Exception\IncorrectPasswordException;
use Rikudou\LemmyApi\Exception\LemmyApiException;
use Rikudou\LemmyApi\Helper\HttpModuleTrait;
use Rikudou\LemmyApi\Response\LoginResponse;
use SensitiveParameter;

final class DefaultLemmyApi implements LemmyApi
{
    use HttpModuleTrait;

    private ?string $jwt = null;

    private readonly string $instanceUrl;

    public function __construct(
        string $instanceUrl,
        private readonly LemmyApiVersion $version,
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        #[ExpectedValues(valuesFromClass: AuthMode::class)]
        private readonly int $authMode = AuthMode::Both,
        private readonly bool $strictDeserialization = true,
    ) {
        if (!preg_match('@^https?://@', $instanceUrl)) {
            $instanceUrl = 'https://' . $instanceUrl;
        }
        $this->instanceUrl = $instanceUrl;
    }

    /**
     * @throws LemmyApiException
     * @throws IncorrectPasswordException
     * @throws ClientExceptionInterface
     */
    public function login(
        string $username,
        #[SensitiveParameter]
        string $password,
        #[SensitiveParameter]
        ?string $totpToken = null
    ): LoginResponse {
        $response = $this->httpClient->sendRequest(
            $this->createRequest('/user/login', HttpMethod::Post, [
                'username_or_email' => $username,
                'password' => $password,
                'totp_2fa_token' => $totpToken,
            ])
        );

        if ($e = $this->getExceptionForInvalidResponse($response)) {
            throw $e;
        }

        $response = LoginResponse::fromRaw($this->getJson($response), $this->strictDeserialization);
        $this->setJwt($response->jwt);

        return $response;
    }

    public function getJwt(): ?string
    {
        return $this->jwt;
    }

    public function setJwt(?string $jwt): void
    {
        $this->jwt = $jwt;
    }

    public function register(
        string $username,
        #[SensitiveParameter]
        string $password,
        bool $showNsfw,
        ?string $email = null,
        ?string $answer = null,
        ?string $captchaAnswer = null,
        ?string $captchaUuid = null,
        ?string $honeypot = null,
    ): LoginResponse {
        $body = [
            'answer' => $answer,
            'captcha_answer' => $captchaAnswer,
            'captcha_uuid' => $captchaUuid,
            'email' => $email,
            'honeypot' => $honeypot,
            'password' => $password,
            'password_verify' => $password,
            'show_nsfw' => $showNsfw,
            'username' => $username,
        ];
        $body = array_filter($body, static fn (mixed $item) => $item !== null);

        $response = $this->httpClient->sendRequest(
            $this->createRequest('/user/register', HttpMethod::Post, $body),
        );

        if ($e = $this->getExceptionForInvalidResponse($response)) {
            throw $e;
        }

        $response = LoginResponse::fromRaw($this->getJson($response), $this->strictDeserialization);
        $this->setJwt($response->jwt);

        return $response;
    }

    public function user(): UserEndpoint
    {
        return new DefaultUserEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function currentUser(): CurrentUserEndpoint
    {
        return new DefaultCurrentUserEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function admin(): AdminEndpoint
    {
        return new DefaultAdminEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function moderator(): ModeratorEndpoint
    {
        return new DefaultModeratorEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function post(): PostEndpoint
    {
        return new DefaultPostEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function community(): CommunityEndpoint
    {
        return new DefaultCommunityEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function comment(): CommentEndpoint
    {
        return new DefaultCommentEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function site(): SiteEndpoint
    {
        return new DefaultSiteEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    public function miscellaneous(): MiscellaneousEndpoint
    {
        return new DefaultMiscellaneousEndpoint(
            jwt: $this->jwt,
            instanceUrl: $this->instanceUrl,
            version: $this->version,
            httpClient: $this->httpClient,
            requestFactory: $this->requestFactory,
            authMode: $this->authMode,
            strictMode: $this->strictDeserialization,
        );
    }

    private function getVersion(): LemmyApiVersion
    {
        return $this->version;
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    private function getInstanceUrl(): string
    {
        return $this->instanceUrl;
    }
}
