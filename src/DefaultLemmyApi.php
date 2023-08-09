<?php

namespace Rikudou\LemmyApi;

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

    public function __construct(
        private readonly string $instanceUrl,
        private readonly LemmyApiVersion $version,
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
    ) {
    }

    /**
     * @throws LemmyApiException
     * @throws IncorrectPasswordException
     * @throws ClientExceptionInterface
     */
    public function login(
        string $username,
        #[SensitiveParameter] string $password,
        #[SensitiveParameter] ?string $totpToken = null
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

        $response = LoginResponse::fromRaw($this->getJson($response));
        $this->setJwt($response->jwt);

        return $response;
    }

    public function setJwt(string $jwt): void
    {
        $this->jwt = $jwt;
    }

    public function register(
        string $username,
        #[SensitiveParameter] string $password,
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

        $response = LoginResponse::fromRaw($this->getJson($response));
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
