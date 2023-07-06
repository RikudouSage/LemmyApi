<?php

namespace Rikudou\LemmyApi\Enum;

enum SearchType: string
{
    case All = 'All';
    case Comments = 'Comments';
    case Posts = 'Posts';
    case Communities = 'Communities';
    case Users = 'Users';
    case Url = 'Url';
}
