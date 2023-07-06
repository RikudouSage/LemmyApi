<?php

namespace Rikudou\LemmyApi\Response;

final readonly class PurgeItemResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $success,
    ) {
    }
}
