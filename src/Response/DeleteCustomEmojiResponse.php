<?php

namespace Rikudou\LemmyApi\Response;

final readonly class DeleteCustomEmojiResponse extends AbstractResponseDto
{
    public function __construct(
        public int $id,
        public bool $success,
    ) {
    }
}
