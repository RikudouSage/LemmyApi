<?php

namespace Rikudou\LemmyApi\Enum;

use Rikudou\LemmyApi\Attribute\Since;

enum CommentSortType: string
{
    case Hot = 'Hot';
    case Top = 'Top';
    case New = 'New';
    case Old = 'Old';

    #[Since('0.19.0')]
    case Controversial = 'Controversial';
}
