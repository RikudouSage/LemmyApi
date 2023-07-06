<?php

namespace Rikudou\LemmyApi\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class ArrayType
{
    /**
     * @param class-string $type
     */
    public function __construct(
        public string $type,
    ) {
    }
}
