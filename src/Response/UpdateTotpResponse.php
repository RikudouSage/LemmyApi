<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\Since;

#[Since('0.19.0')]
final readonly class UpdateTotpResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $enabled,
    ) {
    }
}
