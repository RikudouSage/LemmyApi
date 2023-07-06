<?php

namespace Rikudou\LemmyApi\Enum;

enum RegistrationMode: string
{
    case Closed = 'Closed';
    case RequireApplication = 'RequireApplication';
    case Open = 'Open';
}
