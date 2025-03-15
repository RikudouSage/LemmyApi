<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Attribute\Since;
use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Instance;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\Site;

#[Since('0.19.0')]
final readonly class InstanceBlockView extends AbstractResponseDto
{
    public function __construct(
        public Person $person,
        public Instance $instance,
        public ?Site $site = null,
    ) {
    }
}
