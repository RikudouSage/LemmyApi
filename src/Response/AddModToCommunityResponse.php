<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\CommunityModeratorView;

final readonly class AddModToCommunityResponse extends AbstractResponseDto
{
    /**
     * @param array<CommunityModeratorView> $moderators
     */
    public function __construct(
        #[ArrayType(CommunityModeratorView::class)]
        public array $moderators,
    ) {
    }
}
