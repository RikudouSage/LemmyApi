<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\PersonView;

final readonly class AddAdminResponse extends AbstractResponseDto
{
    /**
     * @param array<PersonView> $admins
     */
    public function __construct(
        #[ArrayType(PersonView::class)]
        public array $admins,
    ) {
    }
}
