<?php

namespace Rikudou\LemmyApi\Response\Model;

final readonly class CaptchaResponse
{
    public function __construct(
        public string $png,
        public string $uuid,
        public string $wav,
    ) {
    }
}
