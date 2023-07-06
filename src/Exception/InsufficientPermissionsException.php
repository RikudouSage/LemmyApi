<?php

namespace Rikudou\LemmyApi\Exception;

use RuntimeException;

final class InsufficientPermissionsException extends RuntimeException implements LemmyApiException
{
}
