<?php

namespace Rikudou\LemmyApi\Enum;

enum SubscribedType: string
{
    case Subscribed = 'Subscribed';
    case NotSubscribed = 'NotSubscribed';
    case Pending = 'Pending';
}
