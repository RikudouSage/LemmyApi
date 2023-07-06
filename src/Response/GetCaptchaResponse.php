<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\Model\CaptchaResponse;

final readonly class GetCaptchaResponse extends AbstractResponseDto
{
    public function __construct(
        public ?CaptchaResponse $ok = null,
    ) {
    }
}
