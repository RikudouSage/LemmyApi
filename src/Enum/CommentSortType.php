<?php

namespace Rikudou\LemmyApi\Enum;

enum CommentSortType: string
{
    case Hot = 'Hot';
    case Top = 'Top';
    case New = 'New';
    case Old = 'Old';
}
