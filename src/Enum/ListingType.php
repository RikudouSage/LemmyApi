<?php

namespace Rikudou\LemmyApi\Enum;

enum ListingType: string
{
    case All = 'All';
    case Local = 'Local';
    case Subscribed = 'Subscribed';
}
