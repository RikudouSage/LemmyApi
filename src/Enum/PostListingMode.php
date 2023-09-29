<?php

namespace Rikudou\LemmyApi\Enum;

use Rikudou\LemmyApi\Attribute\Since;

#[Since('0.19.0')]
enum PostListingMode: string
{
    case List = 'List';
    case Card = 'Card';
    case SmallCard = 'SmallCard';
}
