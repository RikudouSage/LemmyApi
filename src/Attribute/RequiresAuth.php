<?php

namespace Rikudou\LemmyApi\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class RequiresAuth
{
}
