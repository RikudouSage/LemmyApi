<?php

namespace Rikudou\LemmyApi\Endpoint;

use Closure;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\LemmyApiVersion;
use Rikudou\LemmyApi\Helper\HttpModuleTrait;
use Rikudou\LemmyApi\Response\ResponseDto;

abstract readonly class AbstractEndpoint
{
    use HttpModuleTrait;

    public function __construct(
        protected string $jwt,
        protected string $instanceUrl,
        protected LemmyApiVersion $version,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
    ) {
    }

    /**
     * @param array<string, mixed>|null $body
     */
    protected function createAuthenticatedRequest(string $path, HttpMethod $method, ?array $body = null): RequestInterface
    {
        $body ??= [];
        $body['auth'] ??= $this->jwt;
        $body = array_filter($body, static fn (mixed $item) => $item !== null);

        return $this->createRequest($path, $method, $body);
    }

    protected function getVersion(): LemmyApiVersion
    {
        return $this->version;
    }

    protected function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    protected function getInstanceUrl(): string
    {
        return $this->instanceUrl;
    }

    /**
     * @template TResult of mixed
     * @template TResponse of ResponseDto
     *
     * @param array<string, mixed>               $requestBody
     * @param class-string<TResponse>|null       $responseClass
     * @param (Closure(TResponse): TResult)|null $resultCallback
     *
     * @return ($resultCallback is null ? ($responseClass is null ? null : TResponse) : TResult)
     */
    protected function defaultCall(string $path, HttpMethod $method, array $requestBody, ?string $responseClass, ?Closure $resultCallback = null): mixed
    {
        $response = $this->httpClient->sendRequest(
            $this->createAuthenticatedRequest($path, $method, $requestBody),
        );

        if ($e = $this->getExceptionForInvalidResponse($response)) {
            throw $e;
        }

        if ($responseClass === null) {
            return null;
        }

        $response = $responseClass::fromRaw($this->getJson($response));

        if ($resultCallback === null) {
            return $response;
        }

        return $resultCallback($response);
    }
}
