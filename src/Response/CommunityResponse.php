<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Enum\Language;
use Rikudou\LemmyApi\Response\View\CommunityView;

final readonly class CommunityResponse extends AbstractResponseDto
{
    /**
     * @param array<Language> $discussionLanguages
     */
    public function __construct(
        public CommunityView $communityView,
        #[ArrayType(Language::class)]
        public array $discussionLanguages,
    ) {
    }
}
