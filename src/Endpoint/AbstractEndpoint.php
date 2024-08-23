<?php

namespace Rikudou\LemmyApi\Endpoint;

use Closure;
use JetBrains\PhpStorm\ExpectedValues;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Rikudou\LemmyApi\Attribute\NoAuth;
use Rikudou\LemmyApi\Attribute\RequiresAuth;
use Rikudou\LemmyApi\Enum\AuthMode;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\LemmyApiVersion;
use Rikudou\LemmyApi\Exception\LoginRequiredException;
use Rikudou\LemmyApi\Helper\HttpModuleTrait;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\ResponseDto;

abstract readonly class AbstractEndpoint
{
    use HttpModuleTrait;

    public function __construct(
        protected ?string $jwt,
        protected string $instanceUrl,
        protected LemmyApiVersion $version,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        #[ExpectedValues(valuesFromClass: AuthMode::class)]
        protected int $authMode = AuthMode::Both,
        protected bool $strictMode = true,
    ) {
    }

    /**
     * @param array<string, mixed>|null  $body
     * @param array<string, string>|null $headers
     */
    protected function createAuthenticatedRequest(string $path, HttpMethod $method, ?array $body = null, ?array $headers = null): RequestInterface
    {
        $body ??= [];
        $headers ??= [];

        if ($this->authMode & AuthMode::Body) {
            $body['auth'] ??= $this->jwt;
        }
        if ($this->authMode & AuthMode::Header && $this->jwt) {
            $headers['Authorization'] = "Bearer {$this->jwt}";
        }
        $body = array_filter($body, static fn (mixed $item) => $item !== null);

        return $this->createRequest($path, $method, $body, $headers);
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
        if ($this->requiresAuth() && !$this->jwt) {
            throw new LoginRequiredException('Login is required for this endpoint');
        }
        $response = $this->httpClient->sendRequest(
            $this->createAuthenticatedRequest($path, $method, $requestBody),
        );

        if ($e = $this->getExceptionForInvalidResponse($response)) {
            throw $e;
        }

        if ($responseClass === null) {
            return null;
        }

        if (is_a($responseClass, AbstractResponseDto::class, true)) {
            $response = $responseClass::fromRaw($this->getJson($response), $this->strictMode);
        } else {
            $response = $responseClass::fromRaw($this->getJson($response));
        }

        if ($resultCallback === null) {
            return $response;
        }

        return $resultCallback($response);
    }

    private function requiresAuth(): bool
    {
        $reflection = new ReflectionClass($this);
        $noAuth = $this->getAttribute(NoAuth::class, $reflection);
        $reqAuth = $this->getAttribute(RequiresAuth::class, $reflection);

        if ($noAuth) {
            return false;
        }
        if ($reqAuth) {
            return true;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        if (!isset($trace[2])) {
            return false;
        }

        try {
            $method = new ReflectionMethod($this, $trace[2]['function']);

            return $this->getAttribute(RequiresAuth::class, $method) !== null;
        } catch (ReflectionException) {
            return false;
        }
    }

    /**
     * @template T of object
     *
     * @param class-string<T>                     $class
     * @param ReflectionClass<T>|ReflectionMethod $reflection
     *
     * @return T|null
     */
    private function getAttribute(string $class, ReflectionClass|ReflectionMethod $reflection): ?object
    {
        $attributes = $reflection->getAttributes($class);
        if (count($attributes)) {
            return $attributes[0]->newInstance();
        }

        return null;
    }
}
