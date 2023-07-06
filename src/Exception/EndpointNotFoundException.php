<?php

namespace Rikudou\LemmyApi\Exception;

use RuntimeException;

final class EndpointNotFoundException extends RuntimeException implements LemmyApiException
{
}
