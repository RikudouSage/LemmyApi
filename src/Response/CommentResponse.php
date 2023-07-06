<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\CommentView;

final readonly class CommentResponse extends AbstractResponseDto
{
    /**
     * @param array<int> $recipientIds
     */
    public function __construct(
        public CommentView $commentView,
        public array $recipientIds,
        public ?string $formId = null,
    ) {
    }
}
