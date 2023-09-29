<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Enum\Language as LanguageEnum;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\View\CommunityBlockView;
use Rikudou\LemmyApi\Response\View\CommunityFollowerView;
use Rikudou\LemmyApi\Response\View\CommunityModeratorView;
use Rikudou\LemmyApi\Response\View\InstanceBlockView;
use Rikudou\LemmyApi\Response\View\LocalUserView;
use Rikudou\LemmyApi\Response\View\PersonBlockView;

final readonly class MyUserInfo extends AbstractResponseDto
{
    /**
     * @param array<CommunityBlockView>     $communityBlocks
     * @param array<LanguageEnum>           $discussionLanguages
     * @param array<CommunityFollowerView>  $follows
     * @param array<CommunityModeratorView> $moderates
     * @param array<PersonBlockView>        $personBlocks
     * @param array<InstanceBlockView>      $instanceBlocks
     */
    public function __construct(
        #[ArrayType(CommunityBlockView::class)]
        public array $communityBlocks,
        #[ArrayType(LanguageEnum::class)]
        public array $discussionLanguages,
        #[ArrayType(CommunityFollowerView::class)]
        public array $follows,
        public LocalUserView $localUserView,
        #[ArrayType(CommunityModeratorView::class)]
        public array $moderates,
        #[ArrayType(PersonBlockView::class)]
        public array $personBlocks,
        #[Since('0.19.0')]
        #[ArrayType(InstanceBlockView::class)]
        public ?array $instanceBlocks = null,
    ) {
    }
}
