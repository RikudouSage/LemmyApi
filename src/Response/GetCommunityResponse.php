<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Response\Model\Site;
use Rikudou\LemmyApi\Response\View\CommunityModeratorView;
use Rikudou\LemmyApi\Response\View\CommunityView;

final readonly class GetCommunityResponse extends AbstractResponseDto
{
    /**
     * @param array<Language>               $discussionLanguages
     * @param array<CommunityModeratorView> $moderators
     */
    public function __construct(
        public CommunityView $communityView,
        #[ArrayType(Language::class)]
        public array $discussionLanguages,
        #[ArrayType(CommunityModeratorView::class)]
        public array $moderators,
        public ?Site $site = null,
    ) {
    }
}
