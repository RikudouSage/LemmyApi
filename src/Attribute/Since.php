<?php

namespace Rikudou\LemmyApi\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_ALL | Attribute::IS_REPEATABLE)]
final readonly class Since
{
    public function __construct(
        public string $version,
        public ?string $description = null,
    ) {
    }
}
