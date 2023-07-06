<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\CommunityView;

final readonly class BlockCommunityResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $blocked,
        public CommunityView $communityView,
    ) {
    }
}
