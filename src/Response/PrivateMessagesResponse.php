<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\PrivateMessageView;

final readonly class PrivateMessagesResponse extends AbstractResponseDto
{
    /**
     * @param array<PrivateMessageView> $privateMessages
     */
    public function __construct(
        #[ArrayType(PrivateMessageView::class)]
        public array $privateMessages,
    ) {
    }
}
