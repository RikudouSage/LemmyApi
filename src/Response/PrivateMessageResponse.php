<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PrivateMessageView;

final readonly class PrivateMessageResponse extends AbstractResponseDto
{
    public function __construct(
        public PrivateMessageView $privateMessageView,
    ) {
    }
}
