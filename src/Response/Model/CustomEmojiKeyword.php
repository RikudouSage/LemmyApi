<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CustomEmojiKeyword extends AbstractResponseDto
{
    public function __construct(
        public int $customEmojiId,
        public int $id,
        public string $keyword,
    ) {
    }
}
