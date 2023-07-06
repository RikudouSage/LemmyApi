<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommunityView;

final readonly class ListCommunitiesResponse extends AbstractResponseDto
{
    /**
     * @param array<CommunityView> $communities
     */
    public function __construct(
        #[ArrayType(CommunityView::class)]
        public array $communities,
    ) {
    }
}
