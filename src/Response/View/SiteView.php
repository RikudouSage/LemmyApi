<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Aggregates\SiteAggregates;
use Rikudou\LemmyApi\Response\Model\LocalSite;
use Rikudou\LemmyApi\Response\Model\LocalSiteRateLimit;
use Rikudou\LemmyApi\Response\Model\Site;

final readonly class SiteView extends AbstractResponseDto
{
    public function __construct(
        public SiteAggregates $counts,
        public LocalSite $localSite,
        public LocalSiteRateLimit $localSiteRateLimit,
        public Site $site,
    ) {
    }
}
