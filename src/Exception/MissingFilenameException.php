<?php

namespace Rikudou\LemmyApi\Exception;

use LogicException;

final class MissingFilenameException extends LogicException implements LemmyApiException
{
}
