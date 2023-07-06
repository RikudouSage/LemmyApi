<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\PersonMentionView;

final readonly class GetPersonMentionsResponse extends AbstractResponseDto
{
    /**
     * @param array<PersonMentionView> $mentions
     */
    public function __construct(
        #[ArrayType(PersonMentionView::class)]
        public array $mentions,
    ) {
    }
}
