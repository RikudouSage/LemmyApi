<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PersonView;

final readonly class BlockPersonResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $blocked,
        public PersonView $personView,
    ) {
    }
}
