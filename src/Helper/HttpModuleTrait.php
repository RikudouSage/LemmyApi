<?php

namespace Rikudou\LemmyApi\Helper;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rikudou\LemmyApi\Enum\ErrorCode;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\LemmyApiVersion;
use Rikudou\LemmyApi\Exception\HttpApiException;
use Rikudou\LemmyApi\Exception\LemmyApiException;
use Rikudou\LemmyApi\HttpMessage\StringStream;

trait HttpModuleTrait
{
    abstract private function getVersion(): LemmyApiVersion;

    abstract private function getRequestFactory(): RequestFactoryInterface;

    abstract private function getInstanceUrl(): string;

    /**
     * @param array<string, mixed>|null  $body
     * @param array<string, string>|null $headers
     */
    protected function createRequest(string $path, HttpMethod $method, ?array $body = null, ?array $headers = null): RequestInterface
    {
        $headers ??= [];
        $headers['Content-Type'] = 'application/json';

        $request = $this->getRequestFactory()
            ->createRequest($method->value, "{$this->getInstanceUrl()}/api/{$this->getVersion()->value}{$path}")
        ;
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }
        if ($body !== null) {
            if ($method !== HttpMethod::Get) {
                $request = $request->withBody(new StringStream(json_encode($body, flags: JSON_THROW_ON_ERROR)));
            } else {
                $body = array_map(static function (mixed $item) {
                    if (is_bool($item)) {
                        return $item ? 'true' : 'false';
                    }

                    return $item;
                }, $body);
                $query = http_build_query($body);
                $request = $request->withUri($request->getUri()->withQuery($query));
            }
        }

        return $request;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getJson(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        $json = json_decode($body, true);
        if ($json === null && $body) {
            return [
                'error' => $body,
            ];
        }

        assert(is_array($json));

        return $json;
    }

    protected function getExceptionForInvalidResponse(ResponseInterface $response): ?LemmyApiException
    {
        if ($response->getStatusCode() >= 299 || $response->getStatusCode() < 200) {
            $body = $this->getJson($response);
            $body['error'] ??= 'unknown';
            $body['message'] ??= 'no message';

            assert(is_string($body['message']));
            assert(is_string($body['error']));
            $errorCode = ErrorCode::tryFrom($body['error']);
            if ($errorCode !== null) {
                return $errorCode->toException();
            }

            return new HttpApiException("Got an invalid http response: {$response->getStatusCode()}, reason: {$body['error']} ({$body['message']})");
        }

        return null;
    }
}
