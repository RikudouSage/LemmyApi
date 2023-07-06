<?php

namespace Rikudou\LemmyApi\Enum;

enum HttpMethod: string
{
    case Post = 'POST';
    case Get = 'GET';
    case Put = 'PUT';
}
