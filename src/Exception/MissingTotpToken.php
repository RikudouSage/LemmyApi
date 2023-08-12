<?php

namespace Rikudou\LemmyApi\Exception;

use RuntimeException;

final class MissingTotpToken extends RuntimeException implements LemmyApiException
{
}
