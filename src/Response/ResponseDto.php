<?php

namespace Rikudou\LemmyApi\Response;

interface ResponseDto
{
    /**
     * @param array<string, mixed> $raw
     */
    public static function fromRaw(array $raw): static;
}
