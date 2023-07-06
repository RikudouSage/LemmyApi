<?php

namespace Rikudou\LemmyApi\Response;

final readonly class LoginResponse extends AbstractResponseDto
{
    public function __construct(
        public bool $registrationCreated,
        public bool $verifyEmailSent,
        public ?string $jwt = null,
    ) {
    }
}
