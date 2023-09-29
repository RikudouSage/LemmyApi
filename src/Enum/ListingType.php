<?php

namespace Rikudou\LemmyApi\Enum;

use Rikudou\LemmyApi\Attribute\Since;

enum ListingType: string
{
    case All = 'All';
    case Local = 'Local';
    case Subscribed = 'Subscribed';

    #[Since('0.19.0')]
    case ModeratorView = 'ModeratorView';
}
