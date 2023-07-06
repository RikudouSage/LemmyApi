<?php

namespace Rikudou\LemmyApi\Exception;

use RuntimeException;

final class LoginRequiredException extends RuntimeException implements LemmyApiException
{
}
