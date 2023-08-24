<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\CustomEmoji;
use Rikudou\LemmyApi\Response\Model\CustomEmojiKeyword;

final readonly class CustomEmojiView extends AbstractResponseDto
{
    /**
     * @param array<CustomEmojiKeyword> $keywords
     */
    public function __construct(
        public CustomEmoji $customEmoji,
        #[ArrayType(CustomEmojiKeyword::class)]
        public array $keywords,
    ) {
    }
}
