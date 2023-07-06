<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\View\PersonView;

final readonly class BanFromCommunityResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $banned,
        public PersonView $personView,
    ) {
    }
}
