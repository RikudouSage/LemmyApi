<?php

namespace Rikudou\LemmyApi\Enum;

final class AuthMode
{
    public const Body = 2 << 0;

    public const Header = 2 << 1;

    public const Both = self::Body | self::Header;
}
