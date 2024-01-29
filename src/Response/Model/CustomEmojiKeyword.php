<?php

namespace Rikudou\LemmyApi\Response\Model;

use JetBrains\PhpStorm\Deprecated;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class CustomEmojiKeyword extends AbstractResponseDto
{
    public function __construct(
        public int $customEmojiId,
        public string $keyword,
        #[Deprecated('0.19')]
        public ?int $id = null,
    ) {
    }
}
