<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\Model\Tagline;
use Rikudou\LemmyApi\Response\View\SiteView;

final readonly class SiteResponse extends AbstractResponseDto
{
    /**
     * @param array<Tagline> $taglines
     */
    public function __construct(
        public SiteView $siteView,
        #[ArrayType(Tagline::class)]
        public array $taglines,
    ) {
    }
}
