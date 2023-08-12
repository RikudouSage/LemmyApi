<?php

namespace Rikudou\LemmyApi\Exception;

use RuntimeException;

final class IncorrectTotpToken extends RuntimeException implements LemmyApiException
{
}
