<?php

namespace Rikudou\LemmyApi\Enum;

use Rikudou\LemmyApi\Attribute\Since;

#[Since('0.19.0')]
enum PersonSortType: string
{
    case New = 'New';
    case Old = 'Old';
    case MostComments = 'MostComments';
    case CommentScore = 'CommentScore';
    case PostScore = 'PostScore';
    case PostCount = 'PostCount';
}
