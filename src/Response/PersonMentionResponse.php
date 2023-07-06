<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PersonMentionView;

final readonly class PersonMentionResponse extends AbstractResponseDto
{
    public function __construct(
        public PersonMentionView $personMentionView,
    ) {
    }
}
