<?php

namespace Rikudou\LemmyApi\Response;

final readonly class GetUnreadCountResponse extends AbstractResponseDto
{
    public function __construct(
        public int $mentions,
        public int $privateMessages,
        public int $replies,
    ) {
    }
}
