<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\CustomEmojiView;

final readonly class CustomEmojiResponse extends AbstractResponseDto
{
    public function __construct(
        public CustomEmojiView $customEmoji,
    ) {
    }
}
