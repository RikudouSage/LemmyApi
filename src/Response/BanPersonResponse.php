<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PersonView;

final readonly class BanPersonResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $banned,
        public PersonView $personView,
    ) {
    }
}
