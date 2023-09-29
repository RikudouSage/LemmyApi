<?php

namespace Rikudou\LemmyApi\Enum;

use Rikudou\LemmyApi\Attribute\Since;

enum SortType: string
{
    case Active = 'Active';
    case Hot = 'Hot';
    case New = 'New';
    case Old = 'Old';
    case TopDay = 'TopDay';
    case TopWeek = 'TopWeek';
    case TopMonth = 'TopMonth';
    case TopYear = 'TopYear';
    case TopAll = 'TopAll';
    case MostComments = 'MostComments';
    case NewComments = 'NewComments';
    case TopHour = 'TopHour';
    case TopSixHour = 'TopSixHour';
    case TopTwelveHour = 'TopTwelveHour';

    #[Since('0.19.0')]
    case Controversial = 'Controversial';

    #[Since('0.19.0')]
    case Scaled = 'Scaled';
}
