<?php

namespace Rikudou\LemmyApi\Enum;

use Rikudou\LemmyApi\Exception\CommunityBanException;
use Rikudou\LemmyApi\Exception\IncorrectPasswordException;
use Rikudou\LemmyApi\Exception\IncorrectTotpToken;
use Rikudou\LemmyApi\Exception\InsufficientPermissionsException;
use Rikudou\LemmyApi\Exception\LanguageNotAllowedException;
use Rikudou\LemmyApi\Exception\LemmyApiException;
use Rikudou\LemmyApi\Exception\MissingTotpToken;
use Rikudou\LemmyApi\Exception\UserNotFoundException;

enum ErrorCode: string
{
    case UserNotFound = 'couldnt_find_that_username_or_email';
    case IncorrectCredentials = 'password_incorrect';
    case NotAdmin = 'not_an_admin';
    case NotModOrAdmin = 'not_a_mod_or_admin';
    case InvalidPassword = 'invalid_password';
    case CommunityBan = 'community_ban';
    case IncorrectLogin = 'incorrect_login';
    case LanguageNotAllowed = 'language_not_allowed';
    case MissingTotpToken = 'missing_totp_token';
    case IncorrectTotpToken = 'incorrect_totp token';

    public function toException(): LemmyApiException
    {
        return match ($this) {
            self::UserNotFound => new UserNotFoundException('The user could not be found, check the username.'),
            self::IncorrectCredentials, self::IncorrectLogin => new IncorrectPasswordException('The provided username or password is not valid.'),
            self::NotAdmin => new InsufficientPermissionsException('You must be an admin to perform this action.'),
            self::NotModOrAdmin => new InsufficientPermissionsException('You must be an admin or moderator to perform this action.'),
            self::InvalidPassword => new IncorrectPasswordException('The provided password is not valid'),
            self::CommunityBan => new CommunityBanException('The user has been banned from the community'),
            self::LanguageNotAllowed => new LanguageNotAllowedException('The language is not allowed'),
            self::MissingTotpToken => new MissingTotpToken('The TOTP is enabled for this account and you did not send it'),
            self::IncorrectTotpToken => new IncorrectTotpToken('The provided TOTP token is incorrect'),
        };
    }
}
