<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Enum\Language as LanguageEnum;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class Language extends AbstractResponseDto
{
    public function __construct(
        public string $code,
        public LanguageEnum $id,
        public string $name,
    ) {
    }
}
