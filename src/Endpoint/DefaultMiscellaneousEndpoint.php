<?php

namespace Rikudou\LemmyApi\Endpoint;

use finfo;
use Psr\Http\Message\StreamInterface;
use Rikudou\LemmyApi\Dto\UploadImageResult;
use Rikudou\LemmyApi\Enum\HttpMethod;
use Rikudou\LemmyApi\Enum\ListingType;
use Rikudou\LemmyApi\Enum\SearchType;
use Rikudou\LemmyApi\Enum\SortType;
use Rikudou\LemmyApi\Exception\InvalidFileException;
use Rikudou\LemmyApi\Exception\MissingFilenameException;
use Rikudou\LemmyApi\HttpMessage\StringStream;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\ResolveObjectResponse;
use Rikudou\LemmyApi\Response\SearchResponse;
use Rikudou\LemmyApi\Response\UploadImageResponse;
use SplFileInfo;

final readonly class DefaultMiscellaneousEndpoint extends AbstractEndpoint implements MiscellaneousEndpoint
{
    public function resolveObject(string $query): ResolveObjectResponse
    {
        return $this->defaultCall(
            '/resolve_object',
            HttpMethod::Get,
            [
                'q' => $query,
            ],
            ResolveObjectResponse::class,
        );
    }

    public function search(
        string $query,
        Community|int|string|null $community = null,
        int|Person|null $creator = null,
        ?int $limit = null,
        ?ListingType $listingType = null,
        ?int $page = null,
        ?SortType $sort = null,
        ?SearchType $searchType = null,
    ): SearchResponse {
        if ($community instanceof Community) {
            $community = $community->id;
        }
        if ($creator instanceof Person) {
            $creator = $creator->id;
        }

        return $this->defaultCall(
            '/search',
            HttpMethod::Get,
            [
                'community_id' => is_int($community) ? $community : null,
                'community_name' => is_string($community) ? $community : null,
                'creator_id' => $creator,
                'limit' => $limit,
                'listing_type' => $listingType?->value,
                'page' => $page,
                'q' => $query,
                'sort' => $sort?->value,
                'type_' => $searchType?->value,
            ],
            SearchResponse::class,
        );
    }

    public function uploadImage(StreamInterface|SplFileInfo $image, ?string $filename = null): UploadImageResult
    {
        if ($image instanceof SplFileInfo) {
            $filename ??= $image->getBasename();
        }

        if ($filename === null) {
            throw new MissingFilenameException('You must provide a filename for the file if you provide a stream argument.');
        }

        $content = $image instanceof StreamInterface
            ? (string) $image
            : file_get_contents($image->getPathname());

        if (!$content) {
            throw new InvalidFileException('The file content is either empty or the file could not be read.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $contentType = $finfo->buffer($content);

        $boundary = bin2hex(random_bytes(16));
        $requestBody = [
            "--{$boundary}",
            "Content-Disposition: form-data; name=\"images[]\"; filename=\"{$filename}\"",
            "Content-Type: {$contentType}",
            '',
            $content,
            "--{$boundary}--",
        ];
        $requestBody = implode("\r\n", $requestBody);

        $request = $this->requestFactory->createRequest(
            HttpMethod::Post->value,
            "{$this->instanceUrl}/pictrs/image",
        )
            ->withHeader('Content-Type', "multipart/form-data; boundary={$boundary}")
            ->withHeader('Cookie', "jwt={$this->jwt}")
            ->withBody(new StringStream($requestBody));

        $response = $this->httpClient->sendRequest($request);
        if ($e = $this->getExceptionForInvalidResponse($response)) {
            throw $e;
        }

        return new UploadImageResult(UploadImageResponse::fromRaw($this->getJson($response)));
    }
}
