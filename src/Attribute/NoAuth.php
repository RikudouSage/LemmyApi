<?php

namespace Rikudou\LemmyApi\Attribute;

use Attribute;

/**
 * Allows marking whole class as not requiring auth, speeds up the resolution a bit
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class NoAuth
{
}
