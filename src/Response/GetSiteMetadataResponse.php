<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\Model\SiteMetadata;

final readonly class GetSiteMetadataResponse extends AbstractResponseDto
{
    public function __construct(
        public SiteMetadata $metadata,
    ) {
    }
}
