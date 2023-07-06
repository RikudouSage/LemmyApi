<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\PersonView;

final readonly class BannedPersonsResponse extends AbstractResponseDto
{
    /**
     * @param array<PersonView> $banned
     */
    public function __construct(
        #[ArrayType(PersonView::class)]
        public array $banned,
    ) {
    }
}
