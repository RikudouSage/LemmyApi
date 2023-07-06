<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Enum\Language as LanguageEnum;
use Rikudou\LemmyApi\Response\Model\Language as LanguageModel;
use Rikudou\LemmyApi\Response\Model\MyUserInfo;
use Rikudou\LemmyApi\Response\Model\Tagline;
use Rikudou\LemmyApi\Response\View\CustomEmojiView;
use Rikudou\LemmyApi\Response\View\PersonView;
use Rikudou\LemmyApi\Response\View\SiteView;

final readonly class GetSiteResponse extends AbstractResponseDto
{
    /**
     * @param array<PersonView>      $admins
     * @param array<LanguageModel>   $allLanguages
     * @param array<CustomEmojiView> $customEmojis
     * @param array<LanguageEnum>    $discussionLanguages
     * @param array<Tagline>         $taglines
     */
    public function __construct(
        #[ArrayType(PersonView::class)]
        public array $admins,
        #[ArrayType(LanguageModel::class)]
        public array $allLanguages,
        #[ArrayType(CustomEmojiView::class)]
        public array $customEmojis,
        #[ArrayType(LanguageEnum::class)]
        public array $discussionLanguages,
        public SiteView $siteView,
        #[ArrayType(Tagline::class)]
        public array $taglines,
        public string $version,
        public ?MyUserInfo $myUser = null,
    ) {
    }
}
