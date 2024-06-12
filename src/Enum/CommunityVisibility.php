<?php

namespace Rikudou\LemmyApi\Enum;

enum CommunityVisibility: string
{
    case Public = 'Public';
    case LocalOnly = 'LocalOnly';
}
